<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use JsonSerializable;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\InvoiceContact;

/**
 * Represents an account.
 */
class Account extends AbstractResource implements JsonSerializable
{
    /**
     * @var string|null Number of the account
     */
    private ?string $number = null;

    /**
     * @var string Name of the account
     */
    private string $name = '';

    /**
     * @var string|null Customer number of the account
     */
    private ?string $customerNumber = null;

    /**
     * @var Language Language of the account
     */
    private Language $language;

    /**
     * @var bool Indicates if the account is the main account
     */
    private bool $isMain = false;

    /**
     * @var bool Indicates if this account receives invoices or the main account
     */
    private bool $receiveInvoices = false;

    /**
     * @var InvoiceContact Invoice contact of the account
     */
    private InvoiceContact $invoiceContact;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCustomerNumber(): ?string
    {
        return $this->customerNumber;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function setLanguage(Language $language): void
    {
        $this->language = $language;
    }

    public function isMain(): bool
    {
        return $this->isMain;
    }

    public function receiveInvoices(): bool
    {
        return $this->receiveInvoices;
    }

    public function setReceiveInvoices(bool $receiveInvoices): void
    {
        $this->receiveInvoices = $receiveInvoices;
    }

    public function getInvoiceContact(): InvoiceContact
    {
        return $this->invoiceContact;
    }

    public function setInvoiceContact(InvoiceContact $invoiceContact): void
    {
        $this->invoiceContact = $invoiceContact;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->name = $resource->getProperty('name');
        $result->customerNumber = $resource->getProperty('customerNumber');
        $result->language = self::loadObject($resource, 'language', Language::class);
        $result->isMain = (bool) $resource->getProperty('isMain');
        $result->receiveInvoices = (bool) $resource->getProperty('receiveInvoices');
        $result->invoiceContact = self::loadObject($resource, 'invoiceContact', InvoiceContact::class);

        return $result;
    }

    /**
     * @return array{invoiceContact: InvoiceContact, language: string, reciveInvoices: bool}
     */
    public function jsonSerialize(): array
    {
        return [
            'invoiceContact' => $this->invoiceContact,
            'language' => $this->language->getIri(),
            'receiveInvoices' => $this->receiveInvoices,
        ];
    }
}
