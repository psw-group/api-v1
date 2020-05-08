<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Request\OrderRequest;
use PswGroup\Api\Model\Resource\Order;

class OrderRepository extends AbstractRepository
{
    /**
     * Loads an order resource.
     */
    public function load(string $number): ?Order
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (\Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all orders.
     *
     * @return Collection|Order[]
     */
    public function loadAll(): Collection
    {
        $query = ['pagination' => 'false'];

        try {
            $resource = $this->client->get($this->getBaseUrl(), ['query' => $query]);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = $this->entityFromResource($item);
            }

            return new Collection($items);
        } catch (\Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads a paginated list of orders.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|Order[]
     */
    public function loadCollection(int $page, array $filters = [], array $orders = [], ?int $itemsPerPage = null): PaginatedCollection
    {
        $query = $this->prepareQuery($page, $filters, $orders, $itemsPerPage);

        try {
            $resource = $this->client->get($this->getBaseUrl(), ['query' => $query]);

            return $this->buildPaginatedCollection($resource, $page);
        } catch (\Throwable $e) {
            return new PaginatedCollection([], 0, $page, 0);
        }
    }

    /**
     * Creates a new order for the given order request.
     */
    public function order(OrderRequest $request): Order
    {
        $resource = $this->client->post($this->getBaseUrl(), $request);

        return $this->entityFromResource($resource);
    }

    protected function getBaseUrl(): string
    {
        return '/orders';
    }

    /**
     * @return Order
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Order::fromResource($resource);
    }
}
