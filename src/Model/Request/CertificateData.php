<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use JsonSerializable;

/**
 * Represents all data required to order a certificate.
 */
class CertificateData implements JsonSerializable
{
    /**
     * @var string|null CSR file for the request
     */
    private $csrFile;

    /**
     * @var CsrFields|null CSR fields for the request which can override the CSR file
     */
    private $csrFields;

    /**
     * @var Validation[]|null Validation data for all domains
     */
    private $validation;

    /**
     * @var string|null Pickup user name
     */
    private $username;

    /**
     * @var string|null Pickup password
     */
    private $password;

    /**
     * @var string|null Hash algorithm for the certificate
     */
    private $hashAlgorithm;

    /**
     * @var int|null Number of server for the certificate
     */
    private $serverCount;

    /**
     * @var Contact|null Contact which owns the certificate
     */
    private $ownerContact;

    /**
     * @var Contact|null Contact which approves the certificate
     */
    private $approverContact;

    public function getCsrFile(): ?string
    {
        return $this->csrFile;
    }

    public function setCsrFile(?string $csrFile): void
    {
        $this->csrFile = $csrFile;
    }

    public function getCsrFields(): ?CsrFields
    {
        return $this->csrFields;
    }

    public function setCsrFields(?CsrFields $csrFields): void
    {
        $this->csrFields = $csrFields;
    }

    /**
     * @return Validation[]|null
     */
    public function getValidation(): ?array
    {
        return $this->validation;
    }

    /**
     * @param Validation[]|null $validation
     */
    public function setValidation(?array $validation): void
    {
        $this->validation = $validation;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getHashAlgorithm(): ?string
    {
        return $this->hashAlgorithm;
    }

    public function setHashAlgorithm(?string $hashAlgorithm): void
    {
        $this->hashAlgorithm = $hashAlgorithm;
    }

    public function getServerCount(): ?int
    {
        return $this->serverCount;
    }

    public function setServerCount(?int $serverCount): void
    {
        $this->serverCount = $serverCount;
    }

    public function getOwnerContact(): ?Contact
    {
        return $this->ownerContact;
    }

    public function setOwnerContact(?Contact $ownerContact): void
    {
        $this->ownerContact = $ownerContact;
    }

    public function getApproverContact(): ?Contact
    {
        return $this->approverContact;
    }

    public function setApproverContact(?Contact $approverContact): void
    {
        $this->approverContact = $approverContact;
    }

    /**
     * @return array<string, mixed|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'csrFile' => $this->csrFile,
            'csrFields' => $this->csrFields,
            'validation' => $this->validation,
            'username' => $this->username,
            'password' => $this->password,
            'hashAlgorithm' => $this->hashAlgorithm,
            'serverCount' => $this->serverCount,
            'ownerContact' => $this->ownerContact,
            'approverContact' => $this->approverContact,
        ];
    }
}
