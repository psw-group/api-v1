<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\PrepaidActivity;
use Throwable;

/**
 * @extends AbstractRepository<PrepaidActivity>
 */
class PrepaidActivityRepository extends AbstractRepository
{
    /**
     * Loads a prepaid activity resource.
     */
    public function load(string $number): ?PrepaidActivity
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all prepaid activities.
     *
     * @return Collection<int, PrepaidActivity>
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
        } catch (Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads a paginated list of prepaid activities.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, PrepaidActivity>
     */
    public function loadCollection(int $page, array $filters = [], array $orders = [], ?int $itemsPerPage = null): PaginatedCollection
    {
        $query = $this->prepareQuery($page, $filters, $orders, $itemsPerPage);

        try {
            $resource = $this->client->get($this->getBaseUrl(), $query);

            return $this->buildPaginatedCollection($resource, $page);
        } catch (Throwable $e) {
            return new PaginatedCollection([], 0, $page, 0);
        }
    }

    public function recharge(float $amount): PrepaidActivity
    {
        $resource = $this->client->post($this->getBaseUrl(), ['amount' => $amount]);

        return $this->entityFromResource($resource);
    }

    protected function getBaseUrl(): string
    {
        return '/prepaid-account/activities';
    }

    /**
     * @return PrepaidActivity
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return PrepaidActivity::fromResource($resource);
    }
}
