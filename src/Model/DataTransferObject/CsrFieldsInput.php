<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class CsrFieldsInput implements \JsonSerializable
{
    use CsrFieldsData;

    public function setCommonName(?string $commonName): void
    {
        if (strlen($commonName) > 1024) {
            throw new \InvalidArgumentException('The common name must be shorter than 1025 characters.');
        }

        $this->commonName = $commonName;
    }

    public function setCountryName(?string $countryName): void
    {
        if (trim((string) $countryName) === '') {
            $this->countryName = null;

            return;
        }

        if (! preg_match('/^[a-zA-Z]{2}$/', $countryName)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid ISO2 country code.', $countryName));
        }

        $this->countryName = strtoupper($countryName);
    }

    public function setStateOrProvinceName(?string $stateOrProvinceName): void
    {
        if (strlen($stateOrProvinceName) > 255) {
            throw new \InvalidArgumentException('The state or province name must be shorter than 256 characters.');
        }

        $this->stateOrProvinceName = $stateOrProvinceName;
    }

    public function setLocalityName(?string $localityName): void
    {
        if (strlen($localityName) > 255) {
            throw new \InvalidArgumentException('The locality name must be shorter than 256 characters.');
        }

        $this->localityName = $localityName;
    }

    public function setOrganisationName(?string $organisationName): void
    {
        if (strlen($organisationName) > 255) {
            throw new \InvalidArgumentException('The organisation name must be shorter than 256 characters.');
        }

        $this->organisationName = $organisationName;
    }

    public function setOrganisationalUnitName(?string $organisationalUnitName): void
    {
        if (strlen($organisationalUnitName) > 255) {
            throw new \InvalidArgumentException('The organisational unit name must be shorter than 256 characters.');
        }

        $this->organisationalUnitName = $organisationalUnitName;
    }

    public function setEmailAddress(?string $emailAddress): void
    {
        if (trim((string) $emailAddress) === '') {
            $this->emailAddress = null;

            return;
        }

        if (! preg_match('/^[^@]+@[^@]+$/', $emailAddress)) {
            throw new \InvalidArgumentException(sprintf('%s is not a valid email address.', $emailAddress));
        }

        if (strlen($emailAddress) > 255) {
            throw new \InvalidArgumentException('The email address must be shorter than 256 characters.');
        }

        $this->emailAddress = $emailAddress;
    }

    /**
     * @param string[]|null $sans
     */
    public function setSans(?array $sans): void
    {
        $this->sans = $sans;
    }

    public function jsonSerialize()
    {
        return [
            'commonName' => $this->commonName,
            'countryName' => $this->countryName,
            'stateOrProvinceName' => $this->stateOrProvinceName,
            'localityName' => $this->localityName,
            'organisationName' => $this->organisationName,
            'organisationalUnitName' => $this->organisationalUnitName,
            'emailAddress' => $this->emailAddress,
            'sans' => $this->sans,
        ];
    }
}
