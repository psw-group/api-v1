<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Resource\Certificate;

/**
 * Represents one item of an order.
 */
class OrderItem
{
    /**
     * @var string Name of product
     */
    private string $productName;

    /**
     * @var string Number of the product
     */
    private string $productNumber;

    /**
     * @var string|null Description of the order item
     */
    private ?string $description = null;

    /**
     * @var int Quantity of the order item
     */
    private int $quantity;

    /**
     * @var float Net amount of the order item
     */
    private float $itemPriceNet = 0.0;

    /**
     * @var float Net amount of the order item
     */
    private float $rowPriceNet = 0.0;

    /**
     * @var float Gross amount of the order item
     */
    private float $itemPriceGross = 0.0;

    /**
     * @var float Gross amount of the order item
     */
    private float $rowPriceGross = 0.0;

    /**
     * @var float Tax rate of the order item
     */
    private float $taxRate = 0.0;

    /**
     * @var float Tax amount of the order item
     */
    private float $itemTaxValue = 0.0;

    /**
     * @var float Tax amount of the order item
     */
    private float $rowTaxValue = 0.0;

    /**
     * @var Certificate|null Certificate of the order item
     */
    private ?Certificate $certificate = null;

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
