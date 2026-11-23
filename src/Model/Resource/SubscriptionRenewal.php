<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a renewal of a subscription.
 */
class SubscriptionRenewal extends AbstractResource
{
    /**
     * @var string Number of the renewal
     */
    private string $number;

    /**
     * @var string|null Input certificate number
     */
    private ?string $inputCertificateNumber = null;

    /**
     * @var string|null Output certificate number
     */
    private ?string $outputCertificateNumber = null;

    /**
     * @var string|null CSR for the renewal
     */
    private ?string $csr = null;

    /**
     * @var DateTimeInterface|null Planned date for the reminder email
     */
    private ?DateTimeInterface $plannedEmailReminderAt = null;

    /**
     * @var DateTimeInterface|null Date the reminder email was sent
     */
    private ?DateTimeInterface $emailReminderAt = null;

    /**
     * @var DateTimeInterface|null Planned date for the CSR email
     */
    private ?DateTimeInterface $plannedEmailCsrAt = null;

    /**
     * @var DateTimeInterface|null Date the CSR email was sent
     */
    private ?DateTimeInterface $emailCsrAt = null;

    /**
     * @var DateTimeInterface Planned date for the renewal
     */
    private DateTimeInterface $plannedRenewalAt;

    /**
     * @var DateTimeInterface|null Date the renewal was performed
     */
    private ?DateTimeInterface $renewalAt = null;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getInputCertificateNumber(): ?string
    {
        return $this->inputCertificateNumber;
    }

    public function getOutputCertificateNumber(): ?string
    {
        return $this->outputCertificateNumber;
    }

    public function getCsr(): ?string
    {
        return $this->csr;
    }

    public function getPlannedEmailReminderAt(): ?DateTimeInterface
    {
        return $this->plannedEmailReminderAt;
    }

    public function getEmailReminderAt(): ?DateTimeInterface
    {
        return $this->emailReminderAt;
    }

    public function getPlannedEmailCsrAt(): ?DateTimeInterface
    {
        return $this->plannedEmailCsrAt;
    }

    public function getEmailCsrAt(): ?DateTimeInterface
    {
        return $this->emailCsrAt;
    }

    public function getPlannedRenewalAt(): DateTimeInterface
    {
        return $this->plannedRenewalAt;
    }

    public function getRenewalAt(): ?DateTimeInterface
    {
        return $this->renewalAt;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->inputCertificateNumber = $resource->getProperty('inputCertificateNumber');
        $result->outputCertificateNumber = $resource->getProperty('outputCertificateNumber');
        $result->csr = $resource->getProperty('csr');
        $result->plannedEmailReminderAt = self::loadDateTime($resource, 'plannedEmailReminderAt');
        $result->emailReminderAt = self::loadDateTime($resource, 'emailReminderAt');
        $result->plannedEmailCsrAt = self::loadDateTime($resource, 'plannedEmailCsrAt');
        $result->emailCsrAt = self::loadDateTime($resource, 'emailCsrAt');
        $result->plannedRenewalAt = self::loadDateTime($resource, 'plannedRenewalAt') ?? new DateTime();
        $result->renewalAt = self::loadDateTime($resource, 'renewalAt');

        return $result;
    }
}
