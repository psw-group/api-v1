<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use JsonSerializable;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents an user of an account.
 */
class AccountUser extends AbstractResource implements JsonSerializable
{
    /**
     * @var string|null Number of the user
     */
    private ?string $number = null;

    /**
     * @var bool Indicates if the user can login
     */
    private bool $active = false;

    /**
     * @var string First name of the user
     */
    private string $firstname;

    /**
     * @var string Last name of the user
     */
    private string $lastname;

    /**
     * @var string Email of the user
     */
    private string $email;

    /**
     * @var string Password of the user
     */
    private string $password;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->active = $resource->getProperty('active');
        $result->firstname = $resource->getProperty('firstname');
        $result->lastname = $resource->getProperty('lastname');
        $result->email = $resource->getProperty('email');
        $result->password = $resource->getProperty('password');

        return $result;
    }

    /**
     * @return array<string, string|bool>
     */
    public function jsonSerialize(): array
    {
        return [
            'active' => $this->active,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
