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
    private $salutation;

    /**
     * @var string|null First name of the contact
     */
    private $firstname;

    /**
     * @var string|null Last name of the contact
     */
    private $lastname;

    /**
     * @var string|null Telephone number of the contact
     */
    private $telephone;

    /**
     * @var string|null Email address of the contact
     */
    private $email;

    /**
     * @var string|null Line 1 of the address
     */
    private $addressLine1;

    /**
     * @var string|null Line 2 of the address
     */
    private $addressLine2;

    /**
     * @var string|null Line 3 of the address
     */
    private $addressLine3;

    /**
     * @var string|null Zip code of the address
     */
    private $addressZip;

    /**
     * @var string|null City of the address
     */
    private $addressCity;

    /**
     * @var string|null State of the address
     */
    private $addressState;

    /**
     * @var Country|null Country of the address
     */
    private $addressCountry;

    /**
     * @var OrganisationType|null Organisation type of the contact
     */
    private $organisationType;

    /**
     * @var string|null Organisation name of the contact
     */
    private $organisationName;

    /**
     * @var string|null Organisation unit of the contact
     */
    private $organisationUnit;

    /**
     * @var string|null DUNS number of the organisation
     */
    private $organisationDuns;

    /**
     * @var string|null Jurisdiction agency of the organisation
     */
    private $jurisdictionAgency;

    /**
     * @var string|null Jurisdiction number of the organisation
     */
    private $jurisdictionNumber;

    /**
     * @var string|null City of the jurisdiction agency
     */
    private $jurisdictionCity;

    /**
     * @var string|null State of the jurisdiction agency
     */
    private $jurisdictionState;

    /**
     * @var Country|null Country of the jurisdiction agency
     */
    private $jurisdictionCountry;

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
