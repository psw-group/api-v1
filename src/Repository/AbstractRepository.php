<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use PswGroup\Api\Client;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\PaginatedCollection;

abstract class AbstractRepository
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * Constructs an instance of this class.
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    abstract protected function getBaseUrl(): string;

    /**
     * @param string|int $id
     */
    protected function buildItemUrl($id): string
    {
        return $this->getBaseUrl() . '/' . ((string) $id);
    }

    abstract protected function entityFromResource(HalResource $resource): AbstractResource;

    /**
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return mixed[]
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

        if (count($orders) > 0) {
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

    protected function buildPaginatedCollection(HalResource $resource, int $page): PaginatedCollection
    {
        $items = [];

        foreach ($resource->getResource('item') as $item) {
            $items[] = $this->entityFromResource($item);
        }

        return new PaginatedCollection(
            $items,
            (int) $resource->getProperty('totalItems'),
            $page,
            (int) $resource->getProperty('itemsPerPage')
        );
    }
}
