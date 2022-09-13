<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a product sold by PSW GROUP.
 */
class Product extends AbstractResource
{
    /**
     * @var string Number of the product
     */
    private string $number;

    /**
     * @var string Name of the product
     */
    private string $name;

    /**
     * @var CertificateAuthority|null Authority which issues the certificate
     */
    private ?CertificateAuthority $ca = null;

    /**
     * @var CertificateType|null Type of the certificate
     */
    private ?CertificateType $certificateType = null;

    /**
     * @var CertificateValidationType|null Validation type of the certificate
     */
    private ?CertificateValidationType $validationType = null;

    /**
     * @var int|null Validity period of the product
     */
    private ?int $validityPeriod = null;

    /**
     * @var bool Indicates if the www domain is included
     */
    private bool $isWwwIncluded = false;

    /**
     * @var int|null Number of SANs included
     */
    private ?int $sanIncluded = null;

    /**
     * @var int|null Number of SANs possible
     */
    private ?int $sanLimit = null;

    /**
     * @var string|null Platform of the certificate
     */
    private ?string $platform = null;

    /**
     * @var string|null Time to issue the certificate product
     */
    private ?string $timeToIssue = null;

    /**
     * @var string|null Seal of the certificate product
     */
    private ?string $seal = null;

    /**
     * @var string|null Warranty of the certificate product
     */
    private ?string $warranty = null;

    /**
     * @var string[]|null Signature algorithm of the certificate
     */
    private ?array $signatureAlgorithm = null;

    /**
     * @var bool Indicates if the certificate is a limited trial
     */
    private bool $isTrial = false;

    /**
     * @var bool Indicates if the product has variants
     */
    private bool $hasVariants = false;

    /**
     * @var bool Indicates if the product can be ordered
     */
    private bool $isOrderable = false;

    /**
     * @var float Price of the certificate including tax
     */
    private float $priceNet;

    /**
     * @var float Price of the certificate excluding tax
     */
    private float $priceGross;

    /**
     * @var Currency Currency of the price
     */
    private Currency $currency;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCa(): ?CertificateAuthority
    {
        return $this->ca;
    }

    public function getCertificateType(): ?CertificateType
    {
        return $this->certificateType;
    }

    public function getValidationType(): ?CertificateValidationType
    {
        return $this->validationType;
    }

    public function getValidityPeriod(): ?int
    {
        return $this->validityPeriod;
    }

    public function isWwwIncluded(): bool
    {
        return $this->isWwwIncluded;
    }

    public function getSanIncluded(): ?int
    {
        return $this->sanIncluded;
    }

    public function getSanLimit(): ?int
    {
        return $this->sanLimit;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function getTimeToIssue(): ?string
    {
        return $this->timeToIssue;
    }

    public function getSeal(): ?string
    {
        return $this->seal;
    }

    public function getWarranty(): ?string
    {
        return $this->warranty;
    }

    /**
     * @return string[]|null
     */
    public function getSignatureAlgorithm(): ?array
    {
        return $this->signatureAlgorithm;
    }

    public function isTrial(): bool
    {
        return $this->isTrial;
    }

    public function isHasVariants(): bool
    {
        return $this->hasVariants;
    }

    public function isOrderable(): bool
    {
        return $this->isOrderable;
    }

    public function getPriceNet(): float
    {
        return $this->priceNet;
    }

    public function getPriceGross(): float
    {
        return $this->priceGross;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->name = $resource->getProperty('name');
        $result->ca = self::loadObject($resource, 'ca', CertificateAuthority::class);
        $result->certificateType = self::loadObject($resource, 'certificateType', CertificateType::class);
        $result->validationType = self::loadObject($resource, 'validationType', CertificateValidationType::class);
        $result->validityPeriod = $resource->getProperty('validityPeriod');
        $result->isWwwIncluded = $resource->getProperty('isWwwIncluded');
        $result->sanIncluded = $resource->getProperty('sanIncluded');
        $result->sanLimit = $resource->getProperty('sanLimit');
        $result->platform = $resource->getProperty('platform');
        $result->timeToIssue = $resource->getProperty('timeToIssue');
        $result->seal = $resource->getProperty('seal');
        $result->warranty = $resource->getProperty('warranty');
        $result->signatureAlgorithm = $resource->getProperty('signatureAlgorithm');
        $result->isTrial = $resource->getProperty('isTrial');
        $result->hasVariants = $resource->getProperty('hasVariants');
        $result->isOrderable = $resource->getProperty('isOrderable');
        $result->priceNet = $resource->getProperty('priceNet');
        $result->priceGross = $resource->getProperty('priceGross');
        $result->currency = self::loadObject($resource, 'currency', Currency::class);

        return $result;
    }
}
