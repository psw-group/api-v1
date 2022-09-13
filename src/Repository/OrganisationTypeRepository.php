<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\OrganisationType;
use Throwable;

/**
 * @extends AbstractRepository<OrganisationType>
 */
class OrganisationTypeRepository extends AbstractRepository
{
    /**
     * Loads an organisation type resource.
     */
    public function load(string $code): ?OrganisationType
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($code));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all organisation types.
     *
     * @return Collection<int, OrganisationType>
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
     * Loads a paginated list of organisation types.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, OrganisationType>
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

    protected function getBaseUrl(): string
    {
        return '/organisation-types';
    }

    /**
     * @return OrganisationType
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return OrganisationType::fromResource($resource);
    }
}
