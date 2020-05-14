<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Resource\Certificate;

class OrderItem
{
    /**
     * @var string Name of product
     */
    private $productName;

    /**
     * @var string Number of the product
     */
    private $productNumber;

    /**
     * @var string|null Description of the order item
     */
    private $description;

    /**
     * @var int Quantity of the order item
     */
    private $quantity;

    /**
     * @var float Net amount of the order item
     */
    private $itemPriceNet = 0.0;

    /**
     * @var float Net amount of the order item
     */
    private $rowPriceNet = 0.0;

    /**
     * @var float Gross amount of the order item
     */
    private $itemPriceGross = 0.0;

    /**
     * @var float Gross amount of the order item
     */
    private $rowPriceGross = 0.0;

    /**
     * @var float Tax rate of the order item
     */
    private $taxRate = 0.0;

    /**
     * @var float Tax amount of the order item
     */
    private $itemTaxValue = 0.0;

    /**
     * @var float Tax amount of the order item
     */
    private $rowTaxValue = 0.0;

    /**
     * @var Certificate|null
     */
    private $certificate;

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function getProductNumber(): string
    {
        return $this->productNumber;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getItemPriceNet(): float
    {
        return $this->itemPriceNet;
    }

    public function getRowPriceNet(): float
    {
        return $this->rowPriceNet;
    }

    public function getItemPriceGross(): float
    {
        return $this->itemPriceGross;
    }

    public function getRowPriceGross(): float
    {
        return $this->rowPriceGross;
    }

    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    public function getItemTaxValue(): float
    {
        return $this->itemTaxValue;
    }

    public function getRowTaxValue(): float
    {
        return $this->rowTaxValue;
    }

    public function getCertificate(): ?Certificate
    {
        return $this->certificate;
    }

    public static function fromResource(HalResource $resource): self
    {
        $result = new self();

        $result->productName = $resource->getProperty('productName');
        $result->productNumber = $resource->getProperty('productNumber');
        $result->description = $resource->getProperty('description');
        $result->quantity = $resource->getProperty('quantity');
        $result->itemPriceNet = $resource->getProperty('itemPriceNet');
        $result->rowPriceNet = $resource->getProperty('rowPriceNet');
        $result->itemPriceGross = $resource->getProperty('itemPriceGross');
        $result->rowPriceGross = $resource->getProperty('rowPriceGross');
        $result->taxRate = $resource->getProperty('taxRate');
        $result->itemTaxValue = $resource->getProperty('itemTaxValue');
        $result->rowTaxValue = $resource->getProperty('rowTaxValue');
        $result->certificate = AbstractResource::loadObject($resource, 'certificate', Certificate::class);

        return $result;
    }
}
