<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use DateTime;
use DateTimeInterface;
use JsonSerializable;
use PswGroup\Api\Model\Resource\Certificate;

/**
 * Represents all data required for the renewal of a certificate.
 */
class CertificateRenewRequest implements JsonSerializable
{
    /**
     * @var Certificate Certificate which should be renewed
     */
    private Certificate $certificate;

    /**
     * @var CertificateData|null Certificate data for the renewal
     */
    private ?CertificateData $certificateData = null;

    /**
     * @var Contact Contact which receives all order related information including prices
     */
    private Contact $orderContact;

    /**
     * @var string|null VAT-ID to use
     */
    private ?string $vatId = null;

    /**
     * @var string|null Custom number which will be printed on the invoice
     */
    private ?string $customerOrder = null;

    /**
     * @var DateTime|null Desired validation date and time
     */
    private ?DateTime $validationDate = null;

    /**
     * @var File[]|null Files required for the validation
     */
    private ?array $files = null;

    /**
     * @var string|null Comment for the renewal
     */
    private ?string $comment = null;

    public function getCertificate(): Certificate
    {
        return $this->certificate;
    }

    public function setCertificate(Certificate $certificate): void
    {
        $this->certificate = $certificate;
    }

    public function getCertificateData(): ?CertificateData
    {
        return $this->certificateData;
    }

    public function setCertificateData(?CertificateData $certificateData): void
    {
        $this->certificateData = $certificateData;
    }

    public function getOrderContact(): Contact
    {
        return $this->orderContact;
    }

    public function setOrderContact(Contact $orderContact): void
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
     * @return array{certificateNumber: string, certificateRequest: CertificateData|null, orderContact: Contact, vatId: string|null, customerOrder: string|null, validationDate: string|null, files: File[]|null, comment: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'certificateNumber' => $this->certificate->getNumber(),
            'certificateRequest' => $this->certificateData,
            'orderContact' => $this->orderContact,
            'vatId' => $this->vatId,
            'customerOrder' => $this->customerOrder,
            'validationDate' => $this->validationDate?->format(DateTimeInterface::ATOM),
            'files' => $this->files,
            'comment' => $this->comment,
        ];
    }
}
