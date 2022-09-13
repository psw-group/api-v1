<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a known certificate authority.
 */
class CertificateAuthority extends AbstractResource
{
    /**
     * @var string Code of the authority
     */
    private string $code;

    /**
     * @var string Name of the authority
     */
    private string $name;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->code = $resource->getProperty('code');
        $result->name = $resource->getProperty('name');

        return $result;
    }
}
