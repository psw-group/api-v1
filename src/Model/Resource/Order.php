<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\OrderContact;

class Order extends AbstractResource
{
    /**
     * @var string Number of the order
     */
    private $number;

    /**
     * @var OrderState State of the order
     */
    private $state;

    /**
     * @var OrderContact this contact receives all order related information including prices
     */
    private $orderContact;

    /**
     * @var OrderContact this contact receives the invoice
     */
    private $invoiceContact;

    /**
     * @var float Gross amount of the order
     */
    private $priceGross;

    /**
     * @var float Net amount of the order
     */
    private $priceNet;

    /**
     * @var float Tax value of the order
     */
    private $taxValue;

    /**
     * @var Currency Currency of the order
     */
    private $currency;

    /**
     * @var string|null VAT number of the order
     */
    private $vatNumber;

    /**
     * @var string|null Comment of the order
     */
    private $comment;

    /**
     * @var string|null Order number of the customer
     */
    private $customerOrder;

    /**
     * @var DateTimeInterface|null Validation date of the order
     */
    private $validationAt;

    /**
     * @var DateTimeInterface|null Cancellation date of the order
     */
    private $cancelledAt;

    /**
     * @var DateTimeInterface Modification date of the order
     */
    private $updatedAt;

    /**
     * @var DateTimeInterface Creation date of the order
     */
    private $createdAt;

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

    public static function fromResource(HalResource $resource)
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
        $result->updatedAt = self::loadDateTime($resource, 'updatedAt');
        $result->createdAt = self::loadDateTime($resource, 'createdAt');

        return $result;
    }
}