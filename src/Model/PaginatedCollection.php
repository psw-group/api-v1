<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

/**
 * Represents a paginated collection of resources.
 *
 * @template TKey of int
 * @template TValue of AbstractResource
 *
 * @extends Collection<TKey, TValue>
 */
class PaginatedCollection extends Collection
{
    private readonly int $totalItems;

    private readonly int $currentPage;

    private readonly int $itemsPerPage;

    /**
     * Constructs an instance of this class.
     *
     * @param array<TKey, TValue> $items
     */
    public function __construct(array $items, int $totalItems, int $currentPage, int $itemsPerPage)
    {
        parent::__construct($items);

        $this->totalItems = $totalItems;
        $this->itemsPerPage = $itemsPerPage;
        $this->currentPage = $currentPage;
    }

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalPages(): int
    {
        return $this->getTotalItems() > 0 && $this->getItemsPerPage() > 0 ? (int) ceil($this->getTotalItems() / $this->getItemsPerPage()) : 0;
    }
}
