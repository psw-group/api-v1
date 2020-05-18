<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use DateTime;
use JsonSerializable;
use PswGroup\Api\Model\DataTransferObject\CertificateRequest;
use PswGroup\Api\Model\DataTransferObject\ContactInput;
use PswGroup\Api\Model\DataTransferObject\File;

class CertificateRenewRequest implements JsonSerializable
{
    /**
     * @var string
     */
    private $certificateNumber;

    /**
     * @var CertificateRequest|null
     */
    private $certificateRequest;

    /**
     * @var ContactInput
     */
    private $orderContact;

    /**
     * @var string|null
     */
    private $vatId;

    /**
     * @var string|null
     */
    private $customerOrder;

    /**
     * @var DateTime|null
     */
    private $validationDate;

    /**
     * @var File[]|null
     */
    private $files;

    /**
     * @var string|null
     */
    private $comment;

    public function getCertificateNumber(): string
    {
        return $this->certificateNumber;
    }

    public function setCertificateNumber(string $certificateNumber): void
    {
        $this->certificateNumber = $certificateNumber;
    }

    public function getCertificateRequest(): ?CertificateRequest
    {
        return $this->certificateRequest;
    }

    public function setCertificateRequest(?CertificateRequest $certificateRequest): void
    {
        $this->certificateRequest = $certificateRequest;
    }

    public function getOrderContact(): ContactInput
    {
        return $this->orderContact;
    }

    public function setOrderContact(ContactInput $orderContact): void
    {
        $this->orderContact = $orderContact;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setVatId(?string $vatId): void
    {
        $this->vatId = $vatId;
    }

    public function getCustomerOrder(): ?string
    {
        return $this->customerOrder;
    }

    public function setCustomerOrder(?string $customerOrder): void
    {
        $this->customerOrder = $customerOrder;
    }

    public function getValidationDate(): ?DateTime
    {
        return $this->validationDate;
    }

    public function setValidationDate(?DateTime $validationDate): void
    {
        $this->validationDate = $validationDate;
    }

    /**
     * @return File[]|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @param File[]|null $files
     */
    public function setFiles(?array $files): void
    {
        $this->files = $files;
    }

    public function addFile(File $file): void
    {
        $this->files[] = $file;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'certificateNumber' => $this->certificateNumber,
            'certificateRequest' => $this->certificateRequest,
            'orderContact' => $this->orderContact,
            'vatId' => $this->vatId,
            'customerOrder' => $this->customerOrder,
            'validationDate' => $this->validationDate !== null ? $this->validationDate->format(\DateTime::ATOM) : null,
            'files' => $this->files,
            'comment' => $this->comment,
        ];
    }
}
