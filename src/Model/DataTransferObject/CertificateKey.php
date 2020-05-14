<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;

class CertificateKey
{
    use CsrFieldsData;

    /**
     * @var string Content of the key
     */
    private $content;

    /**
     * @var DateTimeInterface|null Start of the validation period of the key
     */
    private $validFrom;

    /**
     * @var DateTimeInterface|null End of the validation period of the key
     */
    private $validTo;

    /**
     * @var string|null SHA-1 Fingerprint of the key
     */
    private $fingerprint;

    /**
     * @var string|null Signature algorithm of the key
     */
    private $signatureAlgorithm;

    /**
     * @var string|null Serial number of the key
     */
    private $serialNumber;

    /**
     * @var string|null Type of the public key of the csr
     */
    private $keyType;

    /**
     * @var int|null Number of bits of the public key of the csr
     */
    private $keyBits;

    /**
     * @var string|null
     */
    private $hash;

    public function getContent(): string
    {
        return $this->content;
    }

    public function getValidFrom(): ?DateTimeInterface
    {
        return $this->validFrom;
    }

    public function getValidTo(): ?DateTimeInterface
    {
        return $this->validTo;
    }

    public function getFingerprint(): ?string
    {
        return $this->fingerprint;
    }

    public function getSignatureAlgorithm(): ?string
    {
        return $this->signatureAlgorithm;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serialNumber;
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
        $result->validFrom = AbstractResource::loadDateTime($resource, 'validFrom');
        $result->validTo = AbstractResource::loadDateTime($resource, 'validTo');
        $result->fingerprint = $resource->getProperty('fingerprint');
        $result->signatureAlgorithm = $resource->getProperty('signatureAlgorithm');
        $result->serialNumber = $resource->getProperty('serialNumber');
        $result->keyType = $resource->getProperty('keyType');
        $result->keyBits = $resource->getProperty('keyBits');
        $result->hash = $resource->getProperty('hash');

        return $result;
    }
}
