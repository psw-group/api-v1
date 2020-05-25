<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\OrganisationType;
use Throwable;

class OrganisationTypeRepository extends AbstractRepository
{
    /**
     * Loads an organisation type resource.
     */
    public function load(string $code): ?OrganisationType
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($code));
        } catch (Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all organisation types.
     *
     * @return Collection|OrganisationType[]
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
     * Loads a paginated list of organisation types.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|OrganisationType[]
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
