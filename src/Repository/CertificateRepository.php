<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\Certificate;

class CertificateRepository extends AbstractRepository
{
    /**
     * Loads a certificate resource.
     */
    public function load(string $number): ?Certificate
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (\Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all certificates.
     *
     * @return Collection|Certificate[]
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
     * Loads a paginated list of certificates.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|Certificate[]
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

    protected function getBaseUrl(): string
    {
        return '/certificates';
    }

    protected function entityFromResource(HalResource $resource): Certificate
    {
        return Certificate::fromResource($resource);
    }
}
