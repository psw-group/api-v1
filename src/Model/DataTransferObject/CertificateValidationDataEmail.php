<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

/**
 * Represents the data for email validation.
 */
class CertificateValidationDataEmail extends CertificateValidationData
{
    /**
     * @var string
     */
    private $email;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getData(): array
    {
        return [
            'email' => $this->email,
        ];
    }
}
