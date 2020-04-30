<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use PswGroup\Api\Model\Resource\Country;
use PswGroup\Api\Model\Resource\OrganisationType;

trait ContactData
{
    /**
     * @var string|null
     */
    private $salutation;
    /**
     * @var string|null
     */
    private $firstname;
    /**
     * @var string|null
     */
    private $lastname;
    /**
     * @var string|null
     */
    private $telephone;
    /**
     * @var string|null
     */
    private $email;
    /**
     * @var string|null
     */
    private $addressLine1;
    /**
     * @var string|null
     */
    private $addressLine2;
    /**
     * @var string|null
     */
    private $addressLine3;
    /**
     * @var string|null
     */
    private $addressZip;
    /**
     * @var string|null
     */
    private $addressCity;
    /**
     * @var string|null
     */
    private $addressState;
    /**
     * @var Country|null
     */
    private $addressCountry;
    /**
     * @var OrganisationType|null
     */
    private $organisationType;
    /**
     * @var string|null
     */
    private $organisationName;
    /**
     * @var string|null
     */
    private $organisationUnit;
    /**
     * @var string|null
     */
    private $organisationDuns;
    /**
     * @var string|null
     */
    private $jurisdictionAgency;
    /**
     * @var string|null
     */
    private $jurisdictionNumber;
    /**
     * @var string|null
     */
    private $jurisdictionCity;
    /**
     * @var string|null
     */
    private $jurisdictionState;
    /**
     * @var Country|null
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
