<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\Resource\CertificateValidationMethod;

/**
 * Represents validation options for a domain.
 */
class CertificateValidationOption
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var array<int, string>
     */
    private $emailAddresses;

    /**
     * @var array<int, CertificateValidationMethod>
     */
    private $methods;

    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return array<int, string>
     */
    public function getEmailAddresses(): array
    {
        return $this->emailAddresses;
    }

    /**
     * @return array<int, CertificateValidationMethod>
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    public static function fromResource(HalResource $resource): self
    {
        $result = new self();

        $result->domain = $resource->getProperty('domain');
        $result->emailAddresses = $resource->getProperty('emailAddresses');
        $result->methods = [];

        foreach ($resource->getProperty('methods') as $method) {
            $result->methods[] = CertificateValidationMethod::fromResource($method);
        }

        return $result;
    }
}
