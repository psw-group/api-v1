<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\AccountUser;
use Throwable;

/**
 * @extends AbstractRepository<AccountUser>
 */
class AccountUserRepository extends AbstractRepository
{
    /**
     * Loads a user resource.
     */
    public function load(string $number): ?AccountUser
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Saves user data and returns the resource.
     *
     * @param AccountUser $data the data to be saved
     *
     * @return AccountUser the created user resource
     */
    public function save(AccountUser $data): AccountUser
    {
        if ($data->getNumber() !== null) {
            $resource = $this->client->put($this->buildItemUrl($data->getNumber()), $data);
        } else {
            $resource = $this->client->post($this->getBaseUrl(), $data);
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Deletes a user resource.
     */
    public function delete(AccountUser $resource): void
    {
        if ($resource->getNumber() === null) {
            return;
        }

        try {
            $this->client->delete($this->buildItemUrl($resource->getNumber()));
        } catch (Throwable) {
        }
    }

    /**
     * Loads all users.
     *
     * @return Collection<int, AccountUser>
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
     * Loads a paginated list of users.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, AccountUser>
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
        return '/users';
    }

    /**
     * @return AccountUser
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return AccountUser::fromResource($resource);
    }
}
