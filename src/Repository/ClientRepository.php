<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\Client;
use Throwable;

/**
 * @extends AbstractRepository<Client>
 */
class ClientRepository extends AbstractRepository
{
    /**
     * Loads an client resource.
     */
    public function load(string $number): ?Client
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Saves client data and returns the resource.
     *
     * @param Client $data the data to be saved
     *
     * @return Client the created client resource
     */
    public function save(Client $data): Client
    {
        if ($data->getNumber() !== null) {
            $resource = $this->client->put($this->buildItemUrl($data->getNumber()), $data);
        } else {
            $resource = $this->client->post($this->getBaseUrl(), $data);
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all clients.
     *
     * @return Collection<int, Client>
     */
    public function loadAll(): Collection
    {
        $resource = $this->client->get($this->getBaseUrl(), ['pagination' => 'false']);
        $items = [];

        foreach ($resource->getResource('item') as $item) {
            $items[] = $this->entityFromResource($item);
        }

        return new Collection($items);
    }

    /**
     * Loads a paginated list of clients.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, Client>
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
        return '/clients';
    }

    /**
     * @return Client
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Client::fromResource($resource);
    }
}
