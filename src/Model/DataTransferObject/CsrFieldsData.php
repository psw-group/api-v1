<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

trait CsrFieldsData
{
    /**
     * @var string|null
     */
    private $commonName;

    /**
     * @var string|null
     */
    private $countryName;

    /**
     * @var string|null
     */
    private $stateOrProvinceName;

    /**
     * @var string|null
     */
    private $localityName;

    /**
     * @var string|null
     */
    private $organisationName;

    /**
     * @var string|null
     */
    private $organisationalUnitName;

    /**
     * @var string|null
     */
    private $emailAddress;

    /**
     * @var string[]|null
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
