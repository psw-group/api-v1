<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\Job;
use PswGroup\Api\Model\Resource\Subscription;
use PswGroup\Api\Model\Resource\SubscriptionRenewal;
use Throwable;

/**
 * @extends AbstractRepository<Subscription>
 */
class SubscriptionRepository extends AbstractRepository
{
    /**
     * Loads a subscription resource.
     */
    public function load(string $number): ?Subscription
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all subscriptions.
     *
     * @return Collection<int, Subscription>
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
     * Loads a paginated list of subscriptions.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, Subscription>
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
     * Loads all renewals of a subscription.
     *
     * @return Collection<int, SubscriptionRenewal>
     */
    public function loadRenewals(Subscription $subscription): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($subscription->getNumber()) . '/renewals', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = SubscriptionRenewal::fromResource($item);
            }

            return new Collection($items);
        } catch (Throwable) {
            return new Collection([]);
        }
    }

    /**
     * Loads a renewal of a subscription.
     */
    public function loadRenewal(Subscription $subscription, string $id): ?SubscriptionRenewal
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($subscription->getNumber()) . '/renewals/' . $id);
        } catch (Throwable) {
            return null;
        }

        return SubscriptionRenewal::fromResource($resource);
    }

    /**
     * Continues a subscription with the given CSR.
     */
    public function continue(Subscription $subscription, string $csrFile): Job
    {
        $resource = $this->client->post(
            '/jobs/subscription/continue',
            [
                'subscriptionNumber' => $subscription->getNumber(),
                'csrFile' => $csrFile,
            ]
        );

        return Job::fromResource($resource);
    }

    protected function getBaseUrl(): string
    {
        return '/subscriptions';
    }

    /**
     * @return Subscription
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Subscription::fromResource($resource);
    }
}
