<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a known currency.
 */
class Currency extends AbstractResource
{
    /**
     * @var string 3 letter currency code as defined by ISO-4217
     */
    private $iso3;

    public function getIso3(): string
    {
        return $this->iso3;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->iso3 = $resource->getProperty('iso3');

        return $result;
    }
}
