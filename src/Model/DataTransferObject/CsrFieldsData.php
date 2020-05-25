<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

trait CsrFieldsData
{
    /**
     * @var string|null Common name field
     */
    private $commonName;

    /**
     * @var string|null Country name field
     */
    private $countryName;

    /**
     * @var string|null State or province field
     */
    private $stateOrProvinceName;

    /**
     * @var string|null Locality name field
     */
    private $localityName;

    /**
     * @var string|null Organisation name field
     */
    private $organisationName;

    /**
     * @var string|null Organisational unit field
     */
    private $organisationalUnitName;

    /**
     * @var string|null Email address field
     */
    private $emailAddress;

    /**
     * @var string[]|null List of subject alternative names
     */
    private $sans;

    public function getCommonName(): ?string
    {
        return $this->commonName;
    }

    public function getCountryName(): ?string
    {
        return $this->countryName;
    }

    public function getStateOrProvinceName(): ?string
    {
        return $this->stateOrProvinceName;
    }

    public function getLocalityName(): ?string
    {
        return $this->localityName;
    }

    public function getOrganisationName(): ?string
    {
        return $this->organisationName;
    }

    public function getOrganisationalUnitName(): ?string
    {
        return $this->organisationalUnitName;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * @return string[]|null
     */
    public function getSans(): ?array
    {
        return $this->sans;
    }
}
