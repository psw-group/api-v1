<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

class Product extends AbstractResource
{
    /**
     * @var string Number of the product
     */
    private $number;

    /**
     * @var string Name of the product
     */
    private $name;

    /**
     * @var CertificateAuthority|null
     */
    private $ca;

    /**
     * @var CertificateType|null
     */
    private $certificateType;

    /**
     * @var CertificateValidationType|null
     */
    private $validationType;

    /**
     * @var int|null Validity period of the product
     */
    private $validityPeriod;

    /**
     * @var bool WWW domain included
     */
    private $isWwwIncluded;

    /**
     * @var int|null Number of SANs included
     */
    private $sanIncluded;

    /**
     * @var int|null Number of SANs possible
     */
    private $sanLimit;

    /**
     * @var string|null Platform of the certificate
     */
    private $platform;

    /**
     * @var string|null Time to issue to certificate product
     */
    private $timeToIssue;

    /**
     * @var string|null Seal of the certificate product
     */
    private $seal;

    /**
     * @var string|null Warranty of the certificate product
     */
    private $warranty;

    /**
     * @var string[]|null
     */
    private $signatureAlgorithm;

    /**
     * @var bool Indicates if the product is a limited trial
     */
    private $isTrial;

    /**
     * @var bool Indicates if the product has variants
     */
    private $hasVariants;

    /**
     * @var bool Indicates if the product can be ordered
     */
    private $isOrderable;

    /**
     * @var float
     */
    private $priceNet;

    /**
     * @var float
     */
    private $priceGross;

    /**
     * @var Currency
     */
    private $currency;

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

    public static function fromResource(HalResource $resource)
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
