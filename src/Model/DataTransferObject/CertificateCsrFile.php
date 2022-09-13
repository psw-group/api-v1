<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;

/**
 * Represents the CSR file of a certificate.
 */
class CertificateCsrFile
{
    use CsrFieldsData;

    /**
     * @var string Content of the CSR file
     */
    private string $content;

    /**
     * @var string|null Type of the public key of the csr
     */
    private ?string $keyType = null;

    /**
     * @var int|null Number of bits of the public key of the csr
     */
    private ?int $keyBits = null;

    /**
     * @var string|null Calculated Hash value of the csr
     */
    private ?string $hash = null;

    public function getContent(): string
    {
        return $this->content;
    }

    public function getKeyType(): ?string
    {
        return $this->keyType;
    }

    public function getKeyBits(): ?int
    {
        return $this->keyBits;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public static function fromResource(HalResource $resource): self
    {
        $result = new self();

        $result->commonName = $resource->getProperty('commonName');
        $result->countryName = $resource->getProperty('countryName');
        $result->stateOrProvinceName = $resource->getProperty('stateOrProvinceName');
        $result->localityName = $resource->getProperty('localityName');
        $result->organisationName = $resource->getProperty('organisationName');
        $result->organisationalUnitName = $resource->getProperty('organisationalUnitName');
        $result->emailAddress = $resource->getProperty('emailAddress');
        $result->sans = $resource->getProperty('sans');
        $result->content = $resource->getProperty('content');
        $result->keyType = $resource->getProperty('keyType');
        $result->keyBits = $resource->getProperty('keyBits');
        $result->hash = $resource->getProperty('hash');

        return $result;
    }
}
