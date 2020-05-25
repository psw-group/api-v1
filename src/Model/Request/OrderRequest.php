<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use DateTimeInterface;

/**
 * Represents all data required for an order.
 */
class OrderRequest implements \JsonSerializable
{
    /**
     * @var OrderItem[] List of items to order
     */
    private $items;

    /**
     * @var Contact Contact which receives all order related information including prices
     */
    private $orderContact;

    /**
     * @var string|null VAT-ID to use in this order
     */
    private $vatId;

    /**
     * @var string|null Custom number which will be printed on the invoice
     */
    private $customerOrder;

    /**
     * @var DateTimeInterface|null Desired validation date and time
     */
    private $validationDate;

    /**
     * @var File[]|null Files required for the validation
     */
    private $files;

    /**
     * @var string|null Comment for the order
     */
    private $comment;

    /**
     * @return OrderItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(OrderItem $item): void
    {
        $this->items[] = $item;
    }

    public function getOrderContact(): Contact
    {
        return $this->orderContact;
    }

    public function setOrderContact(Contact $orderContact): void
    {
        $this->orderContact = $orderContact;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setVatId(?string $vatId): void
    {
        $this->vatId = $vatId;
    }

    public function getCustomerOrder(): ?string
    {
        return $this->customerOrder;
    }

    public function setCustomerOrder(?string $customerOrder): void
    {
        $this->customerOrder = $customerOrder;
    }

    public function getValidationDate(): ?DateTimeInterface
    {
        return $this->validationDate;
    }

    public function setValidationDate(?DateTimeInterface $validationDate): void
    {
        $this->validationDate = $validationDate;
    }

    /**
     * @return File[]|null
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * @param File[]|null $files
     */
    public function setFiles(?array $files): void
    {
        $this->files = $files;
    }

    public function addFile(File $file): void
    {
        $this->files[] = $file;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'orderContact' => $this->orderContact,
            'vatId' => $this->vatId,
            'customerOrder' => $this->customerOrder,
            'validationDate' => $this->validationDate !== null ? $this->validationDate->format(\DateTime::ATOM) : null,
            'files' => $this->files,
            'comment' => $this->comment,
        ];
    }
}
