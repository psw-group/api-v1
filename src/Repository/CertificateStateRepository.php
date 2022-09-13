<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\CertificateState;
use Throwable;

/**
 * @extends AbstractRepository<CertificateState>
 */
class CertificateStateRepository extends AbstractRepository
{
    /**
     * Loads a certificate state resource.
     */
    public function load(string $number): ?CertificateState
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all certificate states.
     *
     * @return Collection<int, CertificateState>
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
     * Loads a paginated list of certificate states.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, CertificateState>
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
        return '/certificate-states';
    }

    /**
     * @return CertificateState
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return CertificateState::fromResource($resource);
    }
}
