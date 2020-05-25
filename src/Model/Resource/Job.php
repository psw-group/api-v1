<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a job.
 */
class Job extends AbstractResource
{
    /**
     * @var int Id of the job
     */
    private $id;

    /**
     * @var int State of the job
     */
    private $state;

    /**
     * @var string Name of the job
     */
    private $name;

    /**
     * @var DateTimeInterface Creation date of the job
     */
    private $createdAt;

    /**
     * @var DateTimeInterface|null Start date of the job
     */
    private $startedAt;

    /**
     * @var DateTimeInterface|null Stop date of the job
     */
    private $stoppedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getState(): int
    {
        return $this->state;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStartedAt(): ?DateTimeInterface
    {
        return $this->startedAt;
    }

    public function getStoppedAt(): ?DateTimeInterface
    {
        return $this->stoppedAt;
    }

    public static function fromResource(HalResource $resource)
    {
        $result = parent::fromResource($resource);

        $result->id = $resource->getProperty('id');
        $result->state = $resource->getProperty('state');
        $result->name = $resource->getProperty('name');
        $result->createdAt = self::loadDateTime($resource, 'createdAt') ?? new DateTime();
        $result->startedAt = self::loadDateTime($resource, 'startedAt');
        $result->stoppedAt = self::loadDateTime($resource, 'stoppedAt');

        return $result;
    }
}
