<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

class Country extends AbstractResource
{
    /**
     * @var string 2 letter country code as defined by ISO-3166
     */
    private $iso2;

    public function getIso2(): string
    {
        return $this->iso2;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->iso2 = $resource->getProperty('iso2');

        return $result;
    }
}
