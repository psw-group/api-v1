<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\DataTransferObject\OrderField;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\CertificateValidationMethod;
use PswGroup\Api\Model\Resource\Product;
use Throwable;

class ProductRepository extends AbstractRepository
{
    /**
     * Loads a product resource.
     */
    public function load(string $number): ?Product
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all products.
     *
     * @return Collection|Product[]
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
     * Loads a paginated list of products.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|Product[]
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

    /**
     * Loads all variants of a product.
     *
     * @return Collection|Product[]
     */
    public function loadVariants(Product $product): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($product->getNumber()) . '/variants', ['pagination' => 'false']);
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
     * Loads all order fields of a product and their constraints.
     *
     * @return OrderField[]|Collection
     */
    public function loadOrderFields(Product $product): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($product->getNumber()) . '/order-fields', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = OrderField::fromResource($item);
            }

            return new Collection($items);
        } catch (Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads all possible validation methods of a product.
     *
     * @return CertificateValidationMethod[]|Collection
     */
    public function loadValidationMethods(Product $product): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($product->getNumber()) . '/validation-methods', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = CertificateValidationMethod::fromResource($item);
            }

            return new Collection($items);
        } catch (Throwable $e) {
            return new Collection([]);
        }
    }

    protected function getBaseUrl(): string
    {
        return '/products';
    }

    /**
     * @return Product
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Product::fromResource($resource);
    }
}
