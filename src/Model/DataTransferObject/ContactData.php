<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

trait ContactData
{
    /**
     * @var string|null Salutation of the contact
     */
    private ?string $salutation = null;

    /**
     * @var string|null First name of the contact
     */
    private ?string $firstname = null;

    /**
     * @var string|null Last name of the contact
     */
    private ?string $lastname = null;

    /**
     * @var string|null Telephone number of the contact
     */
    private ?string $telephone = null;

    /**
     * @var string|null Email address of the contact
     */
    private ?string $email = null;

    /**
     * @var string|null Line 1 of the address
     */
    private ?string $addressLine1 = null;

    /**
     * @var string|null Line 2 of the address
     */
    private ?string $addressLine2 = null;

    /**
     * @var string|null Line 3 of the address
     */
    private ?string $addressLine3 = null;

    /**
     * @var string|null Zip code of the address
     */
    private ?string $addressZip = null;

    /**
     * @var string|null City of the address
     */
    private ?string $addressCity = null;

    /**
     * @var string|null State of the address
     */
    private ?string $addressState = null;

    /**
     * @var Country|null Country of the address
     */
    private ?Country $addressCountry = null;

    /**
     * @var OrganisationType|null Organisation type of the contact
     */
    private ?OrganisationType $organisationType = null;

    /**
     * @var string|null Organisation name of the contact
     */
    private ?string $organisationName = null;

    /**
     * @var string|null Organisation unit of the contact
     */
    private ?string $organisationUnit = null;

    /**
     * @var string|null DUNS number of the organisation
     */
    private ?string $organisationDuns = null;

    /**
     * @var string|null Jurisdiction agency of the organisation
     */
    private ?string $jurisdictionAgency = null;

    /**
     * @var string|null Jurisdiction number of the organisation
     */
    private ?string $jurisdictionNumber = null;

    /**
     * @var string|null City of the jurisdiction agency
     */
    private ?string $jurisdictionCity = null;

    /**
     * @var string|null State of the jurisdiction agency
     */
    private ?string $jurisdictionState = null;

    /**
     * @var Country|null Country of the jurisdiction agency
     */
    private ?Country $jurisdictionCountry = null;

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getAddressLine1(): ?string
    {
        return $this->addressLine1;
    }

    public function getAddressLine2(): ?string
    {
        return $this->addressLine2;
    }

    public function getAddressLine3(): ?string
    {
        return $this->addressLine3;
    }

    public function getAddressZip(): ?string
    {
        return $this->addressZip;
    }

    public function getAddressCity(): ?string
    {
        return $this->addressCity;
    }

    public function getAddressState(): ?string
    {
        return $this->addressState;
    }

    public function getAddressCountry(): ?Country
    {
        return $this->addressCountry;
    }

    public function getOrganisationType(): ?OrganisationType
    {
        return $this->organisationType;
    }

    public function getOrganisationName(): ?string
    {
        return $this->organisationName;
    }

    public function getOrganisationUnit(): ?string
    {
        return $this->organisationUnit;
    }

    public function getOrganisationDuns(): ?string
    {
        return $this->organisationDuns;
    }

    public function getJurisdictionAgency(): ?string
    {
        return $this->jurisdictionAgency;
    }

    public function getJurisdictionNumber(): ?string
    {
        return $this->jurisdictionNumber;
    }

    public function getJurisdictionCity(): ?string
    {
        return $this->jurisdictionCity;
    }

    public function getJurisdictionState(): ?string
    {
        return $this->jurisdictionState;
    }

    public function getJurisdictionCountry(): ?Country
    {
        return $this->jurisdictionCountry;
    }
}
