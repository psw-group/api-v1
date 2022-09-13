<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\DataTransferObject\OrderItem;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Request\OrderRequest;
use PswGroup\Api\Model\Resource\Job;
use PswGroup\Api\Model\Resource\Order;
use Throwable;

/**
 * @extends AbstractRepository<Order>
 */
class OrderRepository extends AbstractRepository
{
    /**
     * Loads an order resource.
     */
    public function load(string $number): ?Order
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all orders.
     *
     * @return Collection<int, Order>
     */
    public function loadAll(): Collection
    {
        try {
            $resource = $this->client->get($this->getBaseUrl(), ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = $this->entityFromResource($item);
            }

            return new Collection($items);
        } catch (Throwable) {
            return new Collection([]);
        }
    }

    /**
     * Loads a paginated list of orders.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, Order>
     */
    public function loadCollection(int $page, array $filters = [], array $orders = [], ?int $itemsPerPage = null): PaginatedCollection
    {
        $query = $this->prepareQuery($page, $filters, $orders, $itemsPerPage);

        try {
            $resource = $this->client->get($this->getBaseUrl(), $query);

            return $this->buildPaginatedCollection($resource, $page);
        } catch (Throwable) {
            return new PaginatedCollection([], 0, $page, 0);
        }
    }

    /**
     * Loads all items of an order.
     *
     * @return Collection<int, OrderItem>
     */
    public function loadItems(Order $order): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($order->getNumber()) . '/items', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = OrderItem::fromResource($item);
            }

            return new Collection($items);
        } catch (Throwable) {
            return new Collection([]);
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

    /**
     * Cancels an order.
     */
    public function cancel(Order $order): Job
    {
        $resource = $this->client->post('/jobs/orders/cancel', ['orderNumber' => $order->getNumber()]);

        return Job::fromResource($resource);
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
