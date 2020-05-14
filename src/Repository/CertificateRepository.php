<?php

declare(strict_types=1);

namespace PswGroup\Api\Repository;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Collection;
use PswGroup\Api\Model\DataTransferObject\CertificateCsrFields;
use PswGroup\Api\Model\DataTransferObject\CertificateCsrFile;
use PswGroup\Api\Model\DataTransferObject\CertificateKey;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationData;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationDataCname;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationDataDnsTxt;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationDataEmail;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationDataHttp;
use PswGroup\Api\Model\DataTransferObject\CertificateValidationOption;
use PswGroup\Api\Model\PaginatedCollection;
use PswGroup\Api\Model\Resource\Certificate;

class CertificateRepository extends AbstractRepository
{
    /**
     * Loads a certificate resource.
     */
    public function load(string $number): ?Certificate
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (\Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all certificates.
     *
     * @return Collection|Certificate[]
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
        } catch (\Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads a paginated list of certificates.
     *
     * @param mixed[]  $filters
     * @param string[] $orders
     *
     * @return PaginatedCollection|Certificate[]
     */
    public function loadCollection(int $page, array $filters = [], array $orders = [], ?int $itemsPerPage = null): PaginatedCollection
    {
        $query = $this->prepareQuery($page, $filters, $orders, $itemsPerPage);

        try {
            $resource = $this->client->get($this->getBaseUrl(), $query);

            return $this->buildPaginatedCollection($resource, $page);
        } catch (\Throwable $e) {
            return new PaginatedCollection([], 0, $page, 0);
        }
    }

    /**
     * Loads the key of a certificate.
     */
    public function loadKey(Certificate $certificate): ?CertificateKey
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/key', ['pagination' => 'false']);
        } catch (\Throwable $e) {
            return null;
        }

        return CertificateKey::fromResource($resource);
    }

    /**
     * Loads the chain of a certificate.
     *
     * @return CertificateKey[]|Collection
     */
    public function loadChain(Certificate $certificate): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/chain', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = CertificateKey::fromResource($item);
            }

            return new Collection($items);
        } catch (\Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Loads the CSR file of a certificate.
     */
    public function loadCsrFile(Certificate $certificate): ?CertificateCsrFile
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/csr-file', ['pagination' => 'false']);
        } catch (\Throwable $e) {
            return null;
        }

        return CertificateCsrFile::fromResource($resource);
    }

    /**
     * Loads the CSR fields of a certificate.
     */
    public function loadCsrFields(Certificate $certificate): ?CertificateCsrFields
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/csr-fields', ['pagination' => 'false']);
        } catch (\Throwable $e) {
            return null;
        }

        return CertificateCsrFields::fromResource($resource);
    }

    /**
     * Returns the current validation method for all domains of a certificate.
     *
     * @return CertificateValidationData[]|CertificateValidationDataEmail[]|CertificateValidationDataHttp[]|CertificateValidationDataCname[]|CertificateValidationDataDnsTxt[]|Collection
     */
    public function loadValidationData(Certificate $certificate): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/validation-data', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = CertificateValidationData::fromResource($item);
            }

            return new Collection($items);
        } catch (\Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Returns available validation methods for all domains of a certificate.
     *
     * @return CertificateValidationOption[]|Collection
     */
    public function loadValidationMethods(Certificate $certificate): Collection
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/validation-methods', ['pagination' => 'false']);
            $items = [];

            foreach ($resource->getResource('item') as $item) {
                $items[] = CertificateValidationOption::fromResource($item);
            }

            return new Collection($items);
        } catch (\Throwable $e) {
            return new Collection([]);
        }
    }

    protected function getBaseUrl(): string
    {
        return '/certificates';
    }

    /**
     * @return Certificate
     */
    protected function entityFromResource(HalResource $resource): AbstractResource
    {
        return Certificate::fromResource($resource);
    }
}
