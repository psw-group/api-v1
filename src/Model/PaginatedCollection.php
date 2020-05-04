<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

/**
 * Represents a paginated collection of resources.
 */
class PaginatedCollection extends Collection
{
    /**
     * @var int
     */
    private $totalItems;
    /**
     * @var int
     */
    private $currentPage;
    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * Constructs an instance of this class.
     *
     * @param AbstractResource[] $items
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
