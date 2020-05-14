<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class ValidationInput implements \JsonSerializable
{
    public const METHOD_EMAIL = 'email';

    public const METHOD_HTTP = 'http';

    public const METHOD_HTTPS = 'https';

    public const METHOD_CNAME = 'cname';

    public const METHOD_DNSTXT = 'dnstxt';

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string|null
     */
    private $email;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(string $name = '', string $method = '', ?string $emailAddress = null)
    {
        $this->setName($name);
        $this->setMethod($method);
        $this->setEmail($emailAddress);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): void
    {
        if (! in_array($method, [self::METHOD_EMAIL, self::METHOD_HTTP, self::METHOD_HTTPS, self::METHOD_CNAME, self::METHOD_DNSTXT], true)) {
            throw new \InvalidArgumentException(sprintf('Validation method "%s" is unknown.', $method));
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

        if (! preg_match('/^[^@]+@[^@]+$/', (string) $email)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid email address.', $email));
        }

        if (strlen((string) $email) > 255) {
            throw new \InvalidArgumentException('The email address must be shorter than 256 characters.');
        }

        $this->email = $email;
    }

    /**
     * @return array<string, string|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'method' => $this->method,
            'email' => $this->email,
        ];
    }
}
