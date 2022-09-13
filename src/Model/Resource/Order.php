<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\OrderContact;

/**
 * Represents an order.
 */
class Order extends AbstractResource
{
    /**
     * @var string Number of the order
     */
    private string $number;

    /**
     * @var OrderState State of the order
     */
    private OrderState $state;

    /**
     * @var OrderContact Contact which receives all order related information including prices
     */
    private OrderContact $orderContact;

    /**
     * @var OrderContact Contact which receives the invoice
     */
    private OrderContact $invoiceContact;

    /**
     * @var float Gross amount of the order
     */
    private float $priceGross;

    /**
     * @var float Net amount of the order
     */
    private float $priceNet;

    /**
     * @var float Tax value of the order
     */
    private float $taxValue;

    /**
     * @var Currency Currency of the order
     */
    private Currency $currency;

    /**
     * @var string|null VAT number of the order
     */
    private ?string $vatNumber = null;

    /**
     * @var string|null Comment of the order
     */
    private ?string $comment = null;

    /**
     * @var string|null Order number of the customer
     */
    private ?string $customerOrder = null;

    /**
     * @var DateTimeInterface|null Validation date of the order
     */
    private ?DateTimeInterface $validationAt = null;

    /**
     * @var DateTimeInterface|null Cancellation date of the order
     */
    private ?DateTimeInterface $cancelledAt = null;

    /**
     * @var DateTimeInterface Modification date of the order
     */
    private DateTimeInterface $updatedAt;

    /**
     * @var DateTimeInterface Creation date of the order
     */
    private DateTimeInterface $createdAt;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getState(): OrderState
    {
        return $this->state;
    }

    public function getOrderContact(): OrderContact
    {
        return $this->orderContact;
    }

    public function getInvoiceContact(): OrderContact
    {
        return $this->invoiceContact;
    }

    public function getPriceGross(): float
    {
        return $this->priceGross;
    }

    public function getPriceNet(): float
    {
        return $this->priceNet;
    }

    public function getTaxValue(): float
    {
        return $this->taxValue;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getCustomerOrder(): ?string
    {
        return $this->customerOrder;
    }

    public function getValidationAt(): ?DateTimeInterface
    {
        return $this->validationAt;
    }

    public function getCancelledAt(): ?DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->state = self::loadObject($resource, 'state', OrderState::class);
        $result->orderContact = self::loadObject($resource, 'orderContact', OrderContact::class);
        $result->invoiceContact = self::loadObject($resource, 'invoiceContact', OrderContact::class);
        $result->priceGross = $resource->getProperty('priceGross');
        $result->priceNet = $resource->getProperty('priceNet');
        $result->taxValue = $resource->getProperty('taxValue');
        $result->currency = self::loadObject($resource, 'currency', Currency::class);
        $result->vatNumber = $resource->getProperty('vatNumber');
        $result->comment = $resource->getProperty('comment');
        $result->customerOrder = $resource->getProperty('customerOrder');
        $result->validationAt = self::loadDateTime($resource, 'validationAt');
        $result->cancelledAt = self::loadDateTime($resource, 'cancelledAt');
        $result->updatedAt = self::loadDateTime($resource, 'updatedAt') ?? new DateTime();
        $result->createdAt = self::loadDateTime($resource, 'createdAt') ?? new DateTime();

        return $result;
    }
}
