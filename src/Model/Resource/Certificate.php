<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use PswGroup\Api\Model\AbstractResource;
use PswGroup\Api\Model\DataTransferObject\CertificateContact;

/**
 * Represents a certificate.
 */
class Certificate extends AbstractResource
{
    /**
     * @var string Number of the certificate
     */
    private string $number;

    /**
     * @var string Name of the certificate
     */
    private string $name;

    /**
     * @var CertificateType Type of the certificate
     */
    private CertificateType $type;

    /**
     * @var CertificateValidationType|null Validation type of the certificate
     */
    private ?CertificateValidationType $validationType = null;

    /**
     * @var CertificateState State of the certificate
     */
    private CertificateState $state;

    /**
     * @var DateTimeInterface|null Start of the validation period of the certificate
     */
    private ?DateTimeInterface $validFrom = null;

    /**
     * @var DateTimeInterface|null End of the validation period of the certificate
     */
    private ?DateTimeInterface $validTo = null;

    /**
     * @var CertificateAuthority Authority which issues the certificate
     */
    private CertificateAuthority $ca;

    /**
     * @var string|null Id of the certificate from the certificate authority
     */
    private ?string $caCertificateId = null;

    /**
     * @var string|null Number of the order from the certificate authority
     */
    private ?string $caOrderNumber = null;

    /**
     * @var string|null Number of the order send to the certificate authority
     */
    private ?string $caPartnerNumber = null;

    /**
     * @var string|null Hash algorithm
     */
    private ?string $hashAlgorithm = null;

    /**
     * @var int Number of servers
     */
    private int $serverCount;

    /**
     * @var string|null Pickup username
     */
    private ?string $username = null;

    /**
     * @var string|null Pickup password
     */
    private ?string $password = null;

    /**
     * @var CertificateContact|null Contact which owns the certificate
     */
    private ?CertificateContact $ownerContact = null;

    /**
     * @var CertificateContact|null Contact which approves the certificate
     */
    private ?CertificateContact $approverContact = null;

    /**
     * @var DateTimeInterface|null Date of the order submission to the certificate authority
     */
    private ?DateTimeInterface $orderedAt = null;

    /**
     * @var DateTimeInterface|null Revocation date of the certificate
     */
    private ?DateTimeInterface $revokedAt = null;

    /**
     * @var DateTimeInterface Date of the last modification of the certificate
     */
    private DateTimeInterface $updatedAt;

    /**
     * @var DateTimeInterface Creation date of the certificate
     */
    private DateTimeInterface $createdAt;

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): CertificateType
    {
        return $this->type;
    }

    public function getValidationType(): ?CertificateValidationType
    {
        return $this->validationType;
    }

    public function getState(): CertificateState
    {
        return $this->state;
    }

    public function getValidFrom(): ?DateTimeInterface
    {
        return $this->validFrom;
    }

    public function getValidTo(): ?DateTimeInterface
    {
        return $this->validTo;
    }

    public function getCa(): CertificateAuthority
    {
        return $this->ca;
    }

    public function getCaCertificateId(): ?string
    {
        return $this->caCertificateId;
    }

    public function getCaOrderNumber(): ?string
    {
        return $this->caOrderNumber;
    }

    public function getCaPartnerNumber(): ?string
    {
        return $this->caPartnerNumber;
    }

    public function getHashAlgorithm(): ?string
    {
        return $this->hashAlgorithm;
    }

    public function getServerCount(): int
    {
        return $this->serverCount;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getOwnerContact(): ?CertificateContact
    {
        return $this->ownerContact;
    }

    public function getApproverContact(): ?CertificateContact
    {
        return $this->approverContact;
    }

    public function getOrderedAt(): ?DateTimeInterface
    {
        return $this->orderedAt;
    }

    public function getRevokedAt(): ?DateTimeInterface
    {
        return $this->revokedAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->number = $resource->getProperty('number');
        $result->name = $resource->getProperty('name');
        $result->type = self::loadObject($resource, 'type', CertificateType::class);
        $result->validationType = self::loadObject($resource, 'validationType', CertificateValidationType::class);
        $result->state = self::loadObject($resource, 'state', CertificateState::class);
        $result->validFrom = self::loadDateTime($resource, 'validFrom');
        $result->validTo = self::loadDateTime($resource, 'validTo');
        $result->ca = self::loadObject($resource, 'ca', CertificateAuthority::class);
        $result->caCertificateId = $resource->getProperty('caCertificateId');
        $result->caOrderNumber = $resource->getProperty('caOrderNumber');
        $result->caPartnerNumber = $resource->getProperty('caPartnerNumber');
        $result->hashAlgorithm = $resource->getProperty('hashAlgorithm');
        $result->serverCount = $resource->getProperty('serverCount');
        $result->username = $resource->getProperty('username');
        $result->password = $resource->getProperty('password');
        $result->ownerContact = self::loadObject($resource, 'ownerContact', CertificateContact::class);
        $result->approverContact = self::loadObject($resource, 'approverContact', CertificateContact::class);
        $result->orderedAt = self::loadDateTime($resource, 'orderedAt');
        $result->revokedAt = self::loadDateTime($resource, 'revokedAt');
        $result->updatedAt = self::loadDateTime($resource, 'updatedAt') ?? new DateTime();
        $result->createdAt = self::loadDateTime($resource, 'createdAt') ?? new DateTime();

        return $result;
    }
}
