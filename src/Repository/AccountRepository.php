<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\Account;
use Throwable;

/**
 * @extends AbstractRepository<Account>
 */
class AccountRepository extends AbstractRepository
{
    /**
     * Loads an account resource.
     */
    public function load(string $number): ?Account
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Saves account data and returns the resource.
     *
     * @param Account $data the data to be saved
     *
     * @return Account the created account resource
     */
    public function save(Account $data): Account
    {
        if ($data->getNumber() !== null) {
            $resource = $this->client->put($this->buildItemUrl($data->getNumber()), $data);
        } else {
            $resource = $this->client->post($this->getBaseUrl(), $data);
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all accounts.
     *
     * @return Collection<int, Account>
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
     * Loads a paginated list of accounts.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, Account>
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
        return '/accounts';
    }

    /**
     * @return Account
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Account::fromResource($resource);
    }
}
