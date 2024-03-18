<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use JsonSerializable;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\WritableContact;

/**
 * Represents a contact of an account.
 */
class AccountContact extends AbstractResource implements JsonSerializable
{
    use WritableContact;

    /**
     * @var string|null Number of the contact
     */
    private ?string $number = null;

    /**
     * @var bool Indicates if the contact can be used as order contact
     */
    private bool $allowedAsOrderContact = false;

    /**
     * @var bool Indicates if the contact can be used as owner contact
     */
    private bool $allowedAsOwnerContact = false;

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function isAllowedAsOrderContact(): bool
    {
        return $this->allowedAsOrderContact;
    }

    public function isAllowedAsOwnerContact(): bool
    {
        return $this->allowedAsOwnerContact;
    }

    public function setAllowedAsOrderContact(bool $allowedAsOrderContact): void
    {
        $this->allowedAsOrderContact = $allowedAsOrderContact;
    }

    public function setAllowedAsOwnerContact(bool $allowedAsOwnerContact): void
    {
        $this->allowedAsOwnerContact = $allowedAsOwnerContact;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->allowedAsOrderContact = $resource->getProperty('allowedAsOrderContact');
        $result->allowedAsOwnerContact = $resource->getProperty('allowedAsOwnerContact');

        $result->salutation = $resource->getProperty('salutation');
        $result->firstname = $resource->getProperty('firstname');
        $result->lastname = $resource->getProperty('lastname');
        $result->telephone = $resource->getProperty('telephone');
        $result->email = $resource->getProperty('email');
        $result->addressLine1 = $resource->getProperty('addressLine1');
        $result->addressLine2 = $resource->getProperty('addressLine2');
        $result->addressLine3 = $resource->getProperty('addressLine3');
        $result->addressZip = $resource->getProperty('addressZip');
        $result->addressCity = $resource->getProperty('addressCity');
        $result->addressState = $resource->getProperty('addressState');
        $result->addressCountry = self::loadObject($resource, 'addressCountry', Country::class);
        $result->organisationType = self::loadObject($resource, 'organisationType', OrganisationType::class);
        $result->organisationName = $resource->getProperty('organisationName');
        $result->organisationUnit = $resource->getProperty('organisationUnit');
        $result->organisationDuns = $resource->getProperty('organisationDuns');
        $result->jurisdictionAgency = $resource->getProperty('jurisdictionAgency');
        $result->jurisdictionNumber = $resource->getProperty('jurisdictionNumber');
        $result->jurisdictionCity = $resource->getProperty('jurisdictionCity');
        $result->jurisdictionState = $resource->getProperty('jurisdictionState');
        $result->jurisdictionCountry = self::loadObject($resource, 'jurisdictionCountry', Country::class);

        return $result;
    }

    /**
     * @return array{allowedAsOrderContact: bool, allowedAsOwnerContact: bool, salutation: string|null, firstname: string|null, lastname: string|null, telephone: string|null, email: string|null, addressLine1: string|null, addressLine2: string|null, addressLine3: string|null, addressZip: string|null, addressCity: string|null, addressState: string|null, addressCountry: string|null, organisationType: string|null, organisationName: string|null, organisationUnit: string|null, organisationDuns: string|null, jurisdictionAgency: string|null, jurisdictionNumber: string|null, jurisdictionCity: string|null, jurisdictionState: string|null, jurisdictionCountry: string|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'allowedAsOrderContact' => $this->allowedAsOrderContact,
            'allowedAsOwnerContact' => $this->allowedAsOwnerContact,

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
