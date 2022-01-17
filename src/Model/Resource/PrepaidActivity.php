<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents an activity of a prepaid account.
 */
class PrepaidActivity extends AbstractResource
{
    /**
     * @var float Value of the activity
     */
    public $amount = 0.0;

    /**
     * @var Currency Value of the activity
     */
    public $currency;

    /**
     * @var string Reference of the activity
     */
    public $reference = '';

    /**
     * @var DateTimeInterface Creation date of the activity
     */
    public $createdAt;

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->amount = $resource->getProperty('amount');
        $result->currency = self::loadObject($resource, 'currency', Currency::class);
        $result->reference = $resource->getProperty('reference');
        $result->createdAt = self::loadDateTime($resource, 'createdAt') ?? new DateTime();

        return $result;
    }
}
