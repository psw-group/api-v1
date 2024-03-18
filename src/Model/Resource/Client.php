<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use JsonSerializable;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a client.
 */
class Client extends AbstractResource implements JsonSerializable
{
    /**
     * @var string|null Number of the client
     */
    public ?string $number = null;

    /**
     * @var string Name of the client
     */
    public string $name = '';

    /**
     * @var string OAuth2 client id
     */
    public string $clientId = '';

    /**
     * @var string OAuth2 client secret
     */
    public string $clientSecret = '';

    /**
     * @var string|null Webhook type for notifications
     */
    public ?string $webhookType = null;

    /**
     * @var string|null Webhook URL for notifications
     */
    public ?string $webhookUrl = null;

    /**
     * @var bool Controls if emails are sent for all processes
     */
    public bool $emailsEnabled = false;

    /**
     * @var array<int, string>|null
     */
    public ?array $ipAddresses = null;

    /**
     * @var Account Account of the client
     */
    public Account $account;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getWebhookType(): ?string
    {
        return $this->webhookType;
    }

    public function setWebhookType(?string $webhookType): void
    {
        $this->webhookType = $webhookType;
    }

    public function getWebhookUrl(): ?string
    {
        return $this->webhookUrl;
    }

    public function setWebhookUrl(?string $webhookUrl): void
    {
        $this->webhookUrl = $webhookUrl;
    }

    public function isEmailsEnabled(): bool
    {
        return $this->emailsEnabled;
    }

    public function setEmailsEnabled(bool $emailsEnabled): void
    {
        $this->emailsEnabled = $emailsEnabled;
    }

    public function getIpAddresses(): ?array
    {
        return $this->ipAddresses;
    }

    public function setIpAddresses(?array $ipAddresses): void
    {
        $this->ipAddresses = $ipAddresses;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    public function setAccount(Account $account): void
    {
        $this->account = $account;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->name = $resource->getProperty('name');
        $result->clientId = $resource->getProperty('clientId');
        $result->clientSecret = $resource->getProperty('clientSecret');
        $result->webhookType = $resource->getProperty('webhookType');
        $result->webhookUrl = $resource->getProperty('webhookUrl');
        $result->emailsEnabled = (bool) $resource->getProperty('isMain');
        $result->ipAddresses = $resource->getProperty('ipAddresses');
        $result->account = self::loadObject($resource, 'account', Account::class);

        return $result;
    }

    /**
     * @return array{name: string, webhookType: string|null, webhookUrl: string|null, emailsEnabled: bool, ipAddresses: array<int, string>|null, account: string}
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'webhookType' => $this->webhookType,
            'webhookUrl' => $this->webhookUrl,
            'emailsEnabled' => $this->emailsEnabled,
            'ipAddresses' => $this->ipAddresses,
            'account' => $this->account->getIri(),
        ];
    }
}
