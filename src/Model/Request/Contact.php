<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use InvalidArgumentException;
use JsonSerializable;
use PswGroup\Api\Model\DataTransferObject\ContactData;
use PswGroup\Api\Model\Resource\AccountContact;
use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

class Contact implements JsonSerializable
{
    use ContactData;

    /**
     * @var AccountContact|null Existing contact to use
     */
    private $contact;

    /**
     * @var bool Indicates if a new contact should be created from the given data
     */
    private $storeData = false;

    public function setSalutation(?string $salutation): void
    {
        if (strlen((string) $salutation) > 16) {
            throw new InvalidArgumentException('The salutation must be shorter than 17 characters.');
        }

        $this->salutation = $salutation;
    }

    public function setFirstname(?string $firstname): void
    {
        if (strlen((string) $firstname) > 32) {
            throw new InvalidArgumentException('The first name must be shorter than 33 characters.');
        }

        $this->firstname = $firstname;
    }

    public function setLastname(?string $lastname): void
    {
        if (strlen((string) $lastname) > 32) {
            throw new InvalidArgumentException('The last name must be shorter than 33 characters.');
        }

        $this->lastname = $lastname;
    }

    public function setTelephone(?string $telephone): void
    {
        if (trim((string) $telephone) === '') {
            $this->telephone = null;

            return;
        }

        if (! preg_match('/^[0-9+\-()\s\/]+$/', (string) $telephone)) {
            throw new InvalidArgumentException(sprintf('The telephone number "%s" contains invalid characters.', $telephone));
        }

        $number = preg_replace('/[^0-9+]+/', '', (string) $telephone);

        if ($number === null) {
            $number = (string) $telephone;
        }

        if (strlen((string) $number) > 0 && $number[0] !== '+') {
            $number = '+49' . $number;
        }

        if (strlen((string) $number) < 8) {
            throw new InvalidArgumentException('The telephone number must be longer than 7 characters.');
        }

        if (strlen((string) $number) > 17) {
            throw new InvalidArgumentException('The telephone number must be shorter than 18 characters.');
        }

        if (! preg_match('/^\+[0-9]+$/', (string) $number)) {
            throw new InvalidArgumentException(sprintf('The telephone number "%s" is not valid.', $telephone));
        }

        $this->telephone = $number;
    }

    public function setEmail(?string $email): void
    {
        if (trim((string) $email) === '') {
            $this->email = null;

            return;
        }

        if (! preg_match('/^[^@]+@[^@]+$/', (string) $email)) {
            throw new InvalidArgumentException(sprintf('%s is not a valid email address.', $email));
        }

        if (strlen((string) $email) > 255) {
            throw new InvalidArgumentException('The email address must be shorter than 256 characters.');
        }

        $this->email = $email;
    }

    public function setAddressLine1(?string $addressLine1): void
    {
        if (strlen((string) $addressLine1) > 128) {
            throw new InvalidArgumentException('The address line must be shorter than 129 characters.');
        }

        $this->addressLine1 = $addressLine1;
    }

    public function setAddressLine2(?string $addressLine2): void
    {
        if (strlen((string) $addressLine2) > 128) {
            throw new InvalidArgumentException('The address line must be shorter than 129 characters.');
        }

        $this->addressLine2 = $addressLine2;
    }

    public function setAddressLine3(?string $addressLine3): void
    {
        if (strlen((string) $addressLine3) > 128) {
            throw new InvalidArgumentException('The address line must be shorter than 129 characters.');
        }

        $this->addressLine3 = $addressLine3;
    }

    public function setAddressZip(?string $addressZip): void
    {
        if (strlen((string) $addressZip) > 16) {
            throw new InvalidArgumentException('The zip code must be shorter than 17 characters.');
        }

        $this->addressZip = $addressZip;
    }

    public function setAddressCity(?string $addressCity): void
    {
        if (strlen((string) $addressCity) > 128) {
            throw new InvalidArgumentException('The city name must be shorter than 129 characters.');
        }

        $this->addressCity = $addressCity;
    }

    public function setAddressState(?string $addressState): void
    {
        if (strlen((string) $addressState) > 64) {
            throw new InvalidArgumentException('The state name must be shorter than 65 characters.');
        }

        $this->addressState = $addressState;
    }

    public function setAddressCountry(?Country $addressCountry): void
    {
        $this->addressCountry = $addressCountry;
    }

    public function setOrganisationType(?OrganisationType $organisationType): void
    {
        $this->organisationType = $organisationType;
    }

    public function setOrganisationName(?string $organisationName): void
    {
        if (strlen((string) $organisationName) > 128) {
            throw new InvalidArgumentException('The organisation name must be shorter than 129 characters.');
        }

        $this->organisationName = $organisationName;
    }

    public function setOrganisationUnit(?string $organisationUnit): void
    {
        if (strlen((string) $organisationUnit) > 128) {
            throw new InvalidArgumentException('The organisation unit must be shorter than 129 characters.');
        }

        $this->organisationUnit = $organisationUnit;
    }

    public function setOrganisationDuns(?string $organisationDuns): void
    {
        if (strlen((string) $organisationDuns) > 32) {
            throw new InvalidArgumentException('The duns number must be shorter than 33 characters.');
        }

        $this->organisationDuns = $organisationDuns;
    }

    public function setJurisdictionAgency(?string $jurisdictionAgency): void
    {
        if (strlen((string) $jurisdictionAgency) > 64) {
            throw new InvalidArgumentException('The jurisdiction agency must be shorter than 65 characters.');
        }

        $this->jurisdictionAgency = $jurisdictionAgency;
    }

    public function setJurisdictionNumber(?string $jurisdictionNumber): void
    {
        if (strlen((string) $jurisdictionNumber) > 16) {
            throw new InvalidArgumentException('The jurisdiction number must be shorter than 17 characters.');
        }

        $this->jurisdictionNumber = $jurisdictionNumber;
    }

    public function setJurisdictionCity(?string $jurisdictionCity): void
    {
        if (strlen((string) $jurisdictionCity) > 64) {
            throw new InvalidArgumentException('The jurisdiction city must be shorter than 65 characters.');
        }

        $this->jurisdictionCity = $jurisdictionCity;
    }

    public function setJurisdictionState(?string $jurisdictionState): void
    {
        if (strlen((string) $jurisdictionState) > 32) {
            throw new InvalidArgumentException('The jurisdiction state must be shorter than 33 characters.');
        }

        $this->jurisdictionState = $jurisdictionState;
    }

    public function setJurisdictionCountry(?Country $jurisdictionCountry): void
    {
        $this->jurisdictionCountry = $jurisdictionCountry;
    }

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
     * @return array<string, string|bool|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'contact' => $this->contact !== null ? $this->contact->getIri() : null,
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
            'addressCountry' => $this->addressCountry !== null ? $this->addressCountry->getIri() : null,
            'organisationType' => $this->organisationType !== null ? $this->organisationType->getIri() : null,
            'organisationName' => $this->organisationName,
            'organisationUnit' => $this->organisationUnit,
            'organisationDuns' => $this->organisationDuns,
            'jurisdictionAgency' => $this->jurisdictionAgency,
            'jurisdictionNumber' => $this->jurisdictionNumber,
            'jurisdictionCity' => $this->jurisdictionCity,
            'jurisdictionState' => $this->jurisdictionState,
            'jurisdictionCountry' => $this->jurisdictionCountry !== null ? $this->jurisdictionCountry->getIri() : null,
        ];
    }
}
