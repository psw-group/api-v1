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
use PswGroup\Api\Model\Request\CertificateRenewRequest;
use PswGroup\Api\Model\Request\Validation;
use PswGroup\Api\Model\Resource\Certificate;
use PswGroup\Api\Model\Resource\Job;
use Throwable;

/**
 * @extends AbstractRepository<Certificate>
 */
class CertificateRepository extends AbstractRepository
{
    /**
     * Loads a certificate resource.
     */
    public function load(string $number): ?Certificate
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($number));
        } catch (Throwable $e) {
            return null;
        }

        return $this->entityFromResource($resource);
    }

    /**
     * Loads all certificates.
     *
     * @return Collection<int, Certificate>
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
     * Loads a paginated list of certificates.
     *
     * @param array<string, mixed>  $filters
     * @param array<string, string> $orders
     *
     * @return PaginatedCollection<int, Certificate>
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
     * Loads the key of a certificate.
     */
    public function loadKey(Certificate $certificate): ?CertificateKey
    {
        try {
            $resource = $this->client->get($this->buildItemUrl($certificate->getNumber()) . '/key', ['pagination' => 'false']);
        } catch (Throwable $e) {
            return null;
        }

        return CertificateKey::fromResource($resource);
    }

    /**
     * Loads the chain of a certificate.
     *
     * @return Collection<int, CertificateKey>
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
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
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
        } catch (Throwable $e) {
            return null;
        }

        return CertificateCsrFields::fromResource($resource);
    }

    /**
     * Returns the current validation method for all domains of a certificate.
     *
     * @return Collection<int, CertificateValidationData|CertificateValidationDataEmail|CertificateValidationDataHttp|CertificateValidationDataCname|CertificateValidationDataDnsTxt>
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
        } catch (Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Returns available validation methods for all domains of a certificate.
     *
     * @return Collection<int, CertificateValidationOption>
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
        } catch (Throwable $e) {
            return new Collection([]);
        }
    }

    /**
     * Changes the validation data of a certificate.
     *
     * @param array<int, Validation> $validation
     */
    public function changeValidation(Certificate $certificate, array $validation): Job
    {
        $resource = $this->client->post(
            '/jobs/certificates/change-validation',
            [
                'certificateNumber' => $certificate->getNumber(),
                'validation' => $validation,
            ]
        );

        return Job::fromResource($resource);
    }

    /**
     * Triggers another validation of a certificate if possible.
     */
    public function triggerValidation(Certificate $certificate): ?Job
    {
        $resource = $this->client->post('/jobs/certificates/trigger-validation', ['certificateNumber' => $certificate->getNumber()]);

        return Job::fromResource($resource);
    }

    /**
     * Sends the validation emails for a certificate again if possible.
     */
    public function resendEmail(Certificate $certificate): ?Job
    {
        $resource = $this->client->post('/jobs/certificates/resend-email', ['certificateNumber' => $certificate->getNumber()]);

        return Job::fromResource($resource);
    }

    /**
     * Reissues a certificate.
     */
    public function reissue(Certificate $certificate, string $csrFile): Job
    {
        $resource = $this->client->post(
            '/jobs/certificates/reissue',
            [
                'certificateNumber' => $certificate->getNumber(),
                'csrFile' => $csrFile,
            ]
        );

        return Job::fromResource($resource);
    }

    /**
     * Cancels the reissue of a certificate.
     */
    public function cancelReissue(Certificate $certificate): Job
    {
        $resource = $this->client->post('/jobs/certificates/cancel-reissue', ['certificateNumber' => $certificate->getNumber()]);

        return Job::fromResource($resource);
    }

    /**
     * Renews a certificate.
     */
    public function renew(CertificateRenewRequest $request): ?Job
    {
        $resource = $this->client->post('/jobs/certificates/renew', $request);

        return Job::fromResource($resource);
    }

    /**
     * Revokes a certificate.
     */
    public function revoke(Certificate $certificate): ?Job
    {
        $resource = $this->client->post('/jobs/certificates/revoke', ['certificateNumber' => $certificate->getNumber()]);

        return Job::fromResource($resource);
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
