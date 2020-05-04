<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\CertificateValidationMethod;

class CertificateValidationMethodRepository extends AbstractRepository
{
    protected function getBaseUrl(): string
    {
        return '/certificate-validation-methods';
    }

    protected function entityFromResource(HalResource $resource): CertificateValidationMethod
    {
        return CertificateValidationMethod::fromResource($resource);
    }

    /**
     * Loads a certificate validation method resource.
     */
    public function load(string $number): ?CertificateValidationMethod
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (\Exception $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all certificate validation methods.
     *
     * @return Collection|CertificateValidationMethod[]
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
        } catch (\Exception $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads a paginated list of certificate validation methods.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|CertificateValidationMethod[]
     */
    public function loadCollection(int $page, array $filters = [], array $orders = [], ?int $itemsPerPage = null): PaginatedCollection
    {
        $query = $this->prepareQuery($page, $filters, $orders, $itemsPerPage);

        try {
            $resource = $this->client->get($this->getBaseUrl(), ['query' => $query]);

            return $this->buildPaginatedCollection($resource, $page);
        } catch (\Exception $e) {
            return new PaginatedCollection([], 0, $page, 0);
        }
    }
}
