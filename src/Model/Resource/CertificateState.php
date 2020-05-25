<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents the state of a certificate.
 */
class CertificateState extends AbstractResource
{
    /**
     * @var string Code of the state
     */
    private $code;

    /**
     * @var string German name of the state
     */
    private $name;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->code = $resource->getProperty('code');
        $result->name = $resource->getProperty('name');

        return $result;
    }
}
