<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a quote.
 */
class Quote extends AbstractResource
{
    public string $number = '';

    public float $priceGross = 0.0;

    public float $priceNet = 0.0;

    public float $taxValue = 0.0;

    public Currency $currency;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    public function getPriceGross(): float
    {
        return $this->priceGross;
    }

    public function setPriceGross(float $priceGross): void
    {
        $this->priceGross = $priceGross;
    }

    public function getPriceNet(): float
    {
        return $this->priceNet;
    }

    public function setPriceNet(float $priceNet): void
    {
        $this->priceNet = $priceNet;
    }

    public function getTaxValue(): float
    {
        return $this->taxValue;
    }

    public function setTaxValue(float $taxValue): void
    {
        $this->taxValue = $taxValue;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->priceGross = $resource->getProperty('priceGross');
        $result->priceNet = $resource->getProperty('priceNet');
        $result->taxValue = $resource->getProperty('taxValue');
        $result->currency = self::loadObject($resource, 'currency', Currency::class);

        return $result;
    }
}
