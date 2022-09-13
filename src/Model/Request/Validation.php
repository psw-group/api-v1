<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use InvalidArgumentException;
use JsonSerializable;

class Validation implements JsonSerializable
{
    /**
     * @var string
     */
    public const METHOD_EMAIL = 'email';

    /**
     * @var string
     */
    public const METHOD_HTTP = 'http';

    /**
     * @var string
     */
    public const METHOD_HTTPS = 'https';

    /**
     * @var string
     */
    public const METHOD_CNAME = 'cname';

    /**
     * @var string
     */
    public const METHOD_DNSTXT = 'dnstxt';

    /**
     * @var string Domain which should be validated
     */
    private string $domain;

    /**
     * @var string Method to use for validation
     */
    private string $method;

    /**
     * @var string|null Email address for validation if the method is "email"
     */
    private ?string $email = null;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $domain = '', string $method = '', ?string $emailAddress = null)
    {
        $this->setDomain($domain);
        $this->setMethod($method);
        $this->setEmail($emailAddress);
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $name): void
    {
        $this->domain = $name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        if (! in_array($method, [self::METHOD_EMAIL, self::METHOD_HTTP, self::METHOD_HTTPS, self::METHOD_CNAME, self::METHOD_DNSTXT], true)) {
            throw new InvalidArgumentException(sprintf('Validation method "%s" is unknown.', $method));
        }

        $this->method = $method;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        if (trim((string) $email) === '') {
            $this->email = null;

            return;
        }

        if (! preg_match('#^[^@]+@[^@]+$#', (string) $email)) {
            throw new InvalidArgumentException(sprintf('%s is not a valid email address.', $email));
        }

        if (strlen((string) $email) > 255) {
            throw new InvalidArgumentException('The email address must be shorter than 256 characters.');
        }

        $this->email = $email;
    }

    /**
     * @return array<string, string|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->domain,
            'method' => $this->method,
            'email' => $this->email,
        ];
    }
}
