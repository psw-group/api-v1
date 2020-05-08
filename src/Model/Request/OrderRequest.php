<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use DateTimeInterface;
use PswGroup\Api\Model\DataTransferObject\ContactInput;
use PswGroup\Api\Model\DataTransferObject\File;
use PswGroup\Api\Model\DataTransferObject\OrderItemInput;

class OrderRequest implements \JsonSerializable
{
    /**
     * @var OrderItemInput[]
     */
    private $items;

    /**
     * @var ContactInput
     */
    private $orderContact;

    /**
     * @var string|null
     */
    private $vatId;

    /**
     * @var string|null
     */
    private $customerOrder;

    /**
     * @var DateTimeInterface|null
     */
    private $validationDate;

    /**
     * @var File[]|null
     */
    private $files;

    /**
     * @var string|null
     */
    private $comment;

    /**
     * @return OrderItemInput[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param OrderItemInput[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(OrderItemInput $item): void
    {
        $this->items[] = $item;
    }

    public function getOrderContact(): ContactInput
    {
        return $this->orderContact;
    }

    public function setOrderContact(ContactInput $orderContact): void
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

    public function jsonSerialize()
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
