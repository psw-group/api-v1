<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\Resource\CertificateValidationMethod;
use RuntimeException;

/**
 * Represents all data used for the validation of a domain.
 */
class CertificateValidationData
{
    private string $domain;

    private CertificateValidationMethod $method;

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }

    public function getMethod(): CertificateValidationMethod
    {
        return $this->method;
    }

    public function setMethod(CertificateValidationMethod $method): void
    {
        $this->method = $method;
    }

    /**
     * @return array<string, string|null>
     */
    public function getData(): array
    {
        return [];
    }

    public static function fromResource(HalResource $resource): self
    {
        $method = AbstractResource::loadObject($resource, 'method', CertificateValidationMethod::class);

        if ($method === null) {
            throw new RuntimeException('Method should not be null.');
        }

        $result = new self();

        switch ($method->getCode()) {
            case 'email':
                $result = new CertificateValidationDataEmail();
                $result->setEmail($resource->getProperty('email'));

                break;

            case 'cname':
                $result = new CertificateValidationDataCname();
                $result->setCname($resource->getProperty('cname'));

                break;

            case 'dnstxt':
                $result = new CertificateValidationDataDnsTxt();
                $result->setDnstxt($resource->getProperty('dnstxt'));

                break;

            case 'http':
            case 'https':
                $result = new CertificateValidationDataHttp();
                $result->setUrl($resource->getProperty('url'));
                $result->setContent($resource->getProperty('content'));

                break;
        }

        $result->setDomain($resource->getProperty('domain'));
        $result->setMethod($method);

        return $result;
    }
}
