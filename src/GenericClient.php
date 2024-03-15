<?php

declare(strict_types=1);

namespace PswGroup\Api;

use BinSoul\Net\Hal\Client\DefaultHalResourceFactory;
use BinSoul\Net\Hal\Client\HalClient;
use BinSoul\Net\Hal\Client\HalResource;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use InvalidArgumentException;
use JsonSerializable;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use PswGroup\Api\Exception\HttpClientException;
use PswGroup\Api\Exception\InvalidResponseException;
use PswGroup\Api\Exception\UnauthorizedException;
use RuntimeException;
use Throwable;

/**
 * Base class for all clients.
 */
class GenericClient implements Client
{
    private string $apiUrl;

    private string $clientId;

    private string $clientSecret;

    private ?string $accessToken = null;

    private ?HalClient $halClient = null;

    private readonly ClientInterface $httpClient;

    private readonly RequestFactoryInterface $requestFactory;

    private readonly UriFactoryInterface $uriFactory;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(
        string $apiUrl,
        string $clientId,
        string $clientSecret,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?UriFactoryInterface $uriFactory = null
    ) {
        $this->apiUrl = rtrim($apiUrl, '/');
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;

        $this->httpClient = $httpClient ?? Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? Psr17FactoryDiscovery::findRequestFactory();
        $this->uriFactory = $uriFactory ?? Psr17FactoryDiscovery::findUriFactory();
    }

    public function get(string $uri, array $query = []): HalResource
    {
        return $this->buildClient()->request('GET', $uri, $this->applyDefaultOptions(['query' => $query]));
    }

    public function post(string $uri, $data): HalResource
    {
        return $this->buildClient()->request('POST', $uri, $this->applyDefaultOptions(['body' => $this->serialize($data)]));
    }

    public function put(string $uri, $data): HalResource
    {
        return $this->buildClient()->request('PUT', $uri, $this->applyDefaultOptions(['body' => $this->serialize($data)]));
    }

    public function delete(string $uri): HalResource
    {
        return $this->buildClient()->request('DELETE', $uri, $this->applyDefaultOptions([]));
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = rtrim($apiUrl, '/');
        $this->halClient = null;
        $this->accessToken = null;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
        $this->accessToken = null;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
        $this->accessToken = null;
    }

    /**
     * @param JsonSerializable|array<string|int, mixed> $object
     */
    protected function serialize(JsonSerializable|array $object): string
    {
        $data = @json_encode($object);

        if ($data === false || json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(sprintf('JSON encode error: %s.', json_last_error_msg()));
        }

        return $data;
    }

    /**
     * Returns an HalClient.
     */
    private function buildClient(): HalClient
    {
        if ($this->halClient === null) {
            $this->halClient = new HalClient(
                $this->uriFactory->createUri($this->apiUrl),
                new DefaultHalResourceFactory(),
                $this->httpClient,
                $this->requestFactory
            );
        }

        return $this->halClient;
    }

    /**
     * Adds options needed for all requests.
     *
     * @param array<string, mixed> $options
     *
     * @return array<string, mixed>
     */
    private function applyDefaultOptions(array $options): array
    {
        $result = $options;

        $result['headers'] = (array) ($result['headers'] ?? []);
        $result['headers']['Authorization'] = 'Bearer ' . $this->getAccessToken();

        return $result;
    }

    /**
     * Returns the current access token or retrieves one if needed.
     */
    private function getAccessToken(): string
    {
        if ($this->accessToken !== null) {
            return $this->accessToken;
        }

        $request = $this->requestFactory->createRequest('POST', $this->uriFactory->createUri($this->apiUrl . '/oauth/token'))
            ->withHeader('Authorization', 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret))
            ->withHeader('Content-Type', 'application/x-www-form-urlencoded');

        $request->getBody()->write('grant_type=client_credentials');

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (Throwable $throwable) {
            throw HttpClientException::create($request, $throwable);
        }

        if ($response->getStatusCode() === 401) {
            throw new UnauthorizedException('Invalid client id or client secret.');
        }

        try {
            $body = $response->getBody()->getContents();
        } catch (Throwable $throwable) {
            throw new RuntimeException(sprintf('Error getting response body: %s.', $throwable->getMessage()), $throwable->getCode(), $throwable);
        }

        $data = [];

        if (trim($body) !== '') {
            $data = @json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new InvalidResponseException(sprintf('JSON parse error: %s.', json_last_error_msg()));
            }
        }

        if (! is_array($data)) {
            throw new InvalidResponseException('No access token found in response.');
        }

        if (! isset($data['access_token']) || ! is_string($data['access_token'])) {
            throw new InvalidResponseException('No access token found in response.');
        }

        $this->accessToken = $data['access_token'];

        return $this->accessToken;
    }
}
