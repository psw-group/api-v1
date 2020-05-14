<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\Resource\CertificateValidationMethod;

class CertificateValidationOption
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string[]
     */
    private $emailAddresses;

    /**
     * @var CertificateValidationMethod[]
     */
    private $methods;

    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * @return string[]
     */
    public function getEmailAddresses(): array
    {
        return $this->emailAddresses;
    }

    /**
     * @return CertificateValidationMethod[]
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
