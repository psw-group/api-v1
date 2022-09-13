<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use JsonSerializable;

/**
 * Represents all data required for a quote.
 */
class QuoteRequest implements JsonSerializable
{
    /**
     * @var array<int, QuoteItem> List of items for the quote
     */
    private array $items = [];

    /**
     * @var Contact|null Contact associated with the quote
     */
    private ?Contact $quoteContact = null;

    /**
     * @var string|null VAT-ID to use in the quote
     */
    private ?string $vatId = null;

    /**
     * @return array<int, QuoteItem>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array<int, QuoteItem> $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    public function addItem(QuoteItem $item): void
    {
        $this->items[] = $item;
    }

    public function getQuoteContact(): ?Contact
    {
        return $this->quoteContact;
    }

    public function setQuoteContact(?Contact $quoteContact): void
    {
        $this->quoteContact = $quoteContact;
    }

    public function getVatId(): ?string
    {
        return $this->vatId;
    }

    public function setVatId(?string $vatId): void
    {
        $this->vatId = $vatId;
    }

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
            'quoteContact' => $this->quoteContact,
            'vatId' => $this->vatId,
        ];
    }
}
