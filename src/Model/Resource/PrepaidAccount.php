<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a prepaid account.
 */
class PrepaidAccount extends AbstractResource
{
    /**
     * @var float Balance of the prepaid account
     */
    public $balance = 0.0;

    public function getBalance(): float
    {
        return $this->balance;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->balance = $resource->getProperty('balance');

        return $result;
    }
}
