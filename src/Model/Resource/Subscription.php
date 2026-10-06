<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a subscription.
 */
class Subscription extends AbstractResource
{
    /**
     * @var string Number of the subscription
     */
    private string $number;

    /**
     * @var string Order number of the subscription
     */
    private string $orderNumber;

    /**
     * @var string|null Initial certificate number of the subscription
     */
    private ?string $certificateNumber = null;

    /**
     * @var string Initial product number
     */
    private string $initialProductNumber;

    /**
     * @var string Initial product name
     */
    private string $initialProductName;

    /**
     * @var int Initial period in days
     */
    private int $initialPeriod;

    /**
     * @var string Renewal product number
     */
    private string $renewalProductNumber;

    /**
     * @var string Renewal product name
     */
    private string $renewalProductName;

    /**
     * @var int Renewal period in days
     */
    private int $renewalPeriod;

    /**
     * @var DateTimeInterface Start date of the subscription
     */
    private DateTimeInterface $startsAt;

    /**
     * @var DateTimeInterface End date of the subscription
     */
    private DateTimeInterface $endsAt;

    /**
     * @var DateTimeInterface|null Date of the previous renewal
     */
    private ?DateTimeInterface $previousRenewalAt = null;

    /**
     * @var DateTimeInterface|null Date of the next renewal
     */
    private ?DateTimeInterface $nextRenewalAt = null;

    /**
     * @var DateTimeInterface|null Cancellation date of the subscription
     */
    private ?DateTimeInterface $cancelledAt = null;

    /**
     * @var DateTimeInterface|null Closure date of the subscription
     */
    private ?DateTimeInterface $closedAt = null;

    /**
     * @var string|null Email address associated with the subscription
     */
    private ?string $email = null;

    /**
     * @var DateTimeInterface Creation date of the subscription
     */
    private DateTimeInterface $createdAt;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function getCertificateNumber(): ?string
    {
        return $this->certificateNumber;
    }

    public function getInitialProductNumber(): string
    {
        return $this->initialProductNumber;
    }

    public function getInitialProductName(): string
    {
        return $this->initialProductName;
    }

    public function getInitialPeriod(): int
    {
        return $this->initialPeriod;
    }

    public function getRenewalProductNumber(): string
    {
        return $this->renewalProductNumber;
    }

    public function getRenewalProductName(): string
    {
        return $this->renewalProductName;
    }

    public function getRenewalPeriod(): int
    {
        return $this->renewalPeriod;
    }

    public function getStartsAt(): DateTimeInterface
    {
        return $this->startsAt;
    }

    public function getEndsAt(): DateTimeInterface
    {
        return $this->endsAt;
    }

    public function getPreviousRenewalAt(): ?DateTimeInterface
    {
        return $this->previousRenewalAt;
    }

    public function getNextRenewalAt(): ?DateTimeInterface
    {
        return $this->nextRenewalAt;
    }

    public function getCancelledAt(): ?DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function getClosedAt(): ?DateTimeInterface
    {
        return $this->closedAt;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->orderNumber = $resource->getProperty('orderNumber');
        $result->certificateNumber = $resource->getProperty('certificateNumber');
        $result->initialProductNumber = $resource->getProperty('initialProductNumber');
        $result->initialProductName = $resource->getProperty('initialProductName');
        $result->initialPeriod = (int) $resource->getProperty('initialPeriod');
        $result->renewalProductNumber = $resource->getProperty('renewalProductNumber');
        $result->renewalProductName = $resource->getProperty('renewalProductName');
        $result->renewalPeriod = (int) $resource->getProperty('renewalPeriod');
        $result->startsAt = self::loadDateTime($resource, 'startsAt') ?? new DateTime();
        $result->endsAt = self::loadDateTime($resource, 'endsAt') ?? new DateTime();
        $result->previousRenewalAt = self::loadDateTime($resource, 'previousRenewalAt');
        $result->nextRenewalAt = self::loadDateTime($resource, 'nextRenewalAt');
        $result->cancelledAt = self::loadDateTime($resource, 'cancelledAt');
        $result->closedAt = self::loadDateTime($resource, 'closedAt');
        $result->email = $resource->getProperty('email');
        $result->createdAt = self::loadDateTime($resource, 'createdAt') ?? new DateTime();

        return $result;
    }
}
