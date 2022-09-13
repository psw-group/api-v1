<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

trait CsrFieldsData
{
    /**
     * @var string|null Common name field
     */
    private ?string $commonName = null;

    /**
     * @var string|null Country name field
     */
    private ?string $countryName = null;

    /**
     * @var string|null State or province field
     */
    private ?string $stateOrProvinceName = null;

    /**
     * @var string|null Locality name field
     */
    private ?string $localityName = null;

    /**
     * @var string|null Organisation name field
     */
    private ?string $organisationName = null;

    /**
     * @var string|null Organisational unit field
     */
    private ?string $organisationalUnitName = null;

    /**
     * @var string|null Email address field
     */
    private ?string $emailAddress = null;

    /**
     * @var string[]|null List of subject alternative names
     */
    private ?array $sans = null;

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
