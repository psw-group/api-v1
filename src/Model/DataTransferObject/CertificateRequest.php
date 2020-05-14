<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class CertificateRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $csrFile;

    /**
     * @var CsrFieldsInput|null
     */
    private $csrFields;

    /**
     * @var ValidationInput[]|null
     */
    private $validation;

    /**
     * @var string|null
     */
    private $username;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var string|null
     */
    private $hashAlgorithm;

    /**
     * @var int|null
     */
    private $serverCount;

    /**
     * @var ContactInput|null
     */
    private $ownerContact;

    /**
     * @var ContactInput|null
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

    public function getCsrFields(): ?CsrFieldsInput
    {
        return $this->csrFields;
    }

    public function setCsrFields(?CsrFieldsInput $csrFields): void
    {
        $this->csrFields = $csrFields;
    }

    /**
     * @return ValidationInput[]|null
     */
    public function getValidation(): ?array
    {
        return $this->validation;
    }

    /**
     * @param ValidationInput[]|null $validation
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

    public function getOwnerContact(): ?ContactInput
    {
        return $this->ownerContact;
    }

    public function setOwnerContact(?ContactInput $ownerContact): void
    {
        $this->ownerContact = $ownerContact;
    }

    public function getApproverContact(): ?ContactInput
    {
        return $this->approverContact;
    }

    public function setApproverContact(?ContactInput $approverContact): void
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
