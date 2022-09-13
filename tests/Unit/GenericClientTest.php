<?php

declare(strict_types=1);

namespace PswGroup\Test\Api\Unit;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use PswGroup\Api\Exception\InvalidResponseException;
use PswGroup\Api\Exception\UnauthorizedException;
use PswGroup\Api\GenericClient;
use PswGroup\Test\Api\RequestFactory;
use PswGroup\Test\Api\UriFactory;

class GenericClientTest extends TestCase
{
    public function test_constructor(): void
    {
        $client = new GenericClient('https://api.psw-group.de/v1', 'clientId', 'clientSecret');
        $this->assertEquals('https://api.psw-group.de/v1', $client->getApiUrl());
        $this->assertEquals('clientId', $client->getClientId());
        $this->assertEquals('clientSecret', $client->getClientSecret());
    }

    public function test_prepares_url(): void
    {
        $client = new GenericClient('https://api.psw-group.de/v1/', 'clientId', 'clientSecret');
        $this->assertEquals('https://api.psw-group.de/v1', $client->getApiUrl());

        $client->setApiUrl('https://test-api.psw-group.de/v1/');
        $this->assertEquals('https://test-api.psw-group.de/v1', $client->getApiUrl());
    }

    public function test_getters_and_setters(): void
    {
        $client = new GenericClient('https://api.psw-group.de/v1', 'clientId', 'clientSecret');
        $client->setApiUrl('https://test-api.psw-group.de/v1');
        $this->assertEquals('https://test-api.psw-group.de/v1', $client->getApiUrl());

        $client->setClientId('id');
        $this->assertEquals('id', $client->getClientId());

        $client->setClientSecret('secret');
        $this->assertEquals('secret', $client->getClientSecret());
    }

    public function test_invalid_credentials(): void
    {
        $this->expectException(UnauthorizedException::class);

        $client = $this->buildClient(new Response(401, ['Content-Type' => 'application/problem+json'], '{}'));
        $client->get('/products');
    }

    public function test_json_error(): void
    {
        $this->expectException(InvalidResponseException::class);

        $client = $this->buildClient(new Response(200, ['Content-Type' => 'application/hal+json'], '{"abc":}'));
        $client->get('/products');
    }

    public function test_missing_accesstoken(): void
    {
        $this->expectException(InvalidResponseException::class);

        $client = $this->buildClient(new Response(200, ['Content-Type' => 'application/hal+json'], '{"foo":"bar"}'));
        $client->get('/products');
    }

    public function test_get_response(): void
    {
        $client = $this->buildClient(
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"access_token":"accessToken"}'),
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"foo":"bar"}')
        );

        $response = $client->get('/products', ['number' => 'A000001']);
        $this->assertEquals('bar', $response->getProperty('foo'));
    }

    public function test_post_response(): void
    {
        $client = $this->buildClient(
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"access_token":"accessToken"}'),
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"foo":"bar"}')
        );

        $response = $client->post('/products', ['foo' => 'bar']);
        $this->assertEquals('bar', $response->getProperty('foo'));
    }

    public function test_put_response(): void
    {
        $client = $this->buildClient(
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"access_token":"accessToken"}'),
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"foo":"bar"}')
        );

        $response = $client->put('/products/A000001', ['foo' => 'bar']);
        $this->assertEquals('bar', $response->getProperty('foo'));
    }

    public function test_delete_response(): void
    {
        $client = $this->buildClient(
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"access_token":"accessToken"}'),
            new Response(200, ['Content-Type' => 'application/hal+json'], '{"foo":"bar"}')
        );

        $response = $client->delete('/products/A000001');
        $this->assertEquals('bar', $response->getProperty('foo'));
    }

    private function buildClient(ResponseInterface $firstResponse, ?ResponseInterface $secondResponse = null): GenericClient
    {
        $client = new Client();
        $client->addResponse($firstResponse);

        if ($secondResponse !== null) {
            $client->addResponse($secondResponse);
        }

        $requestFactory = new RequestFactory();
        $uriFactory = new UriFactory();

        return new GenericClient(
            'https://test-api.psw-group.de/v1',
            'clientId',
            'clientSecret',
            $client,
            $requestFactory,
            $uriFactory
        );
    }
}
