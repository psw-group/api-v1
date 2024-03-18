<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use JsonSerializable;
use PswGroup\Api\Model\DataTransferObject\WritableContact;
use PswGroup\Api\Model\Resource\AccountContact;

class Contact implements JsonSerializable
{
    use WritableContact;

    /**
     * @var AccountContact|null Existing contact to use instead of providing new contact data
     */
    private ?AccountContact $contact = null;

    /**
     * @var bool Indicates if a new contact should be created from the given data
     */
    private bool $storeData = false;

    public function getContact(): ?AccountContact
    {
        return $this->contact;
    }

    public function setContact(?AccountContact $contact): void
    {
        $this->contact = $contact;
    }

    public function getStoreData(): bool
    {
        return $this->storeData;
    }

    public function setStoreData(bool $storeData): void
    {
        $this->storeData = $storeData;
    }

    /**
     * @return array{contact: string|null, storeData: bool, salutation: string|null, firstname: string|null, lastname: string|null, telephone: string|null, email: string|null, addressLine1: string|null, addressLine2: string|null, addressLine3: string|null, addressZip: string|null, addressCity: string|null, addressState: string|null, addressCountry: string|null, organisationType: string|null, organisationName: string|null, organisationUnit: string|null, organisationDuns: string|null, jurisdictionAgency: string|null, jurisdictionNumber: string|null, jurisdictionCity: string|null, jurisdictionState: string|null, jurisdictionCountry: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'contact' => $this->contact?->getIri(),
            'storeData' => $this->storeData,

            'salutation' => $this->salutation,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'addressLine3' => $this->addressLine3,
            'addressZip' => $this->addressZip,
            'addressCity' => $this->addressCity,
            'addressState' => $this->addressState,
            'addressCountry' => $this->addressCountry?->getIri(),
            'organisationType' => $this->organisationType?->getIri(),
            'organisationName' => $this->organisationName,
            'organisationUnit' => $this->organisationUnit,
            'organisationDuns' => $this->organisationDuns,
            'jurisdictionAgency' => $this->jurisdictionAgency,
            'jurisdictionNumber' => $this->jurisdictionNumber,
            'jurisdictionCity' => $this->jurisdictionCity,
            'jurisdictionState' => $this->jurisdictionState,
            'jurisdictionCountry' => $this->jurisdictionCountry?->getIri(),
        ];
    }
}
