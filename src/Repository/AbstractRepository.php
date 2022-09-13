<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use InvalidArgumentException;
use PswGroup\Api\Client;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\PaginatedCollection;
use Stringable;

/**
 * Represents a repository of resources.
 *
 * @template TResource of AbstractResource
 */
abstract class AbstractRepository
{
    protected Client $client;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract protected function getBaseUrl(): string;

    protected function buildItemUrl(string|int $id): string
    {
        return $this->getBaseUrl() . '/' . ($id);
    }

    /**
     * @return TResource
     */
    abstract protected function entityFromResource(HalResource $resource): AbstractResource;

    /**
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return array<string, mixed>
     */
    protected function prepareQuery(int $page, array $filters, array $orders, ?int $itemsPerPage): array
    {
        $query = [];

        foreach ($filters as $key => $value) {
            if ($value === null || $value === '') {
                continue;
            }

            if (! is_array($value)) {
                if ($value instanceof DateTime) {
                    $value = $value->format('Y-m-dTH:i:s');
                } elseif ($value instanceof AbstractResource) {
                    $value = $value->getIri();
                } elseif (is_object($value) && ! $value instanceof Stringable) {
                    throw new InvalidArgumentException(sprintf('Object of type "%s" cannot be cast to string.', $value::class));
                }

                $query[$key] = (string) $value;
            } else {
                foreach ($value as $name => $prop) {
                    if ($prop instanceof DateTime) {
                        $prop = $prop->format('Y-m-dTH:i:s');
                    } elseif ($prop instanceof AbstractResource) {
                        $prop = $prop->getIri();
                    }

                    $query[$key . '[' . $name . ']'] = (string) $prop;
                }
            }
        }

        if ($orders !== []) {
            $query['order'] = [];

            foreach ($orders as $key => $value) {
                if (trim($value) === '') {
                    continue;
                }

                $query['order'][$key] = $value;
            }
        }

        if ($itemsPerPage) {
            $query['itemsPerPage'] = $itemsPerPage;
        }

        $query['page'] = $page;

        return $query;
    }

    /**
     * @return PaginatedCollection<int, TResource>
     */
    protected function buildPaginatedCollection(HalResource $resource, int $page): PaginatedCollection
    {
        $items = [];

        foreach ($resource->getResource('item') as $item) {
            $items[] = $this->entityFromResource($item);
        }

        return new PaginatedCollection(
            $items,
            is_numeric($resource->getProperty('totalItems')) ? (int) $resource->getProperty('totalItems') : 0,
            $page,
            is_numeric($resource->getProperty('itemsPerPage')) ? (int) $resource->getProperty('itemsPerPage') : 0
        );
    }
}
