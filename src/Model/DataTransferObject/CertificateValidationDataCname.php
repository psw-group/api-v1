<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

/**
 * Represents the data for CNAME validation.
 */
class CertificateValidationDataCname extends CertificateValidationData
{
    /**
     * @var string
     */
    private $cname;

    public function getCname(): string
    {
        return $this->cname;
    }

    public function setCname(string $cname): void
    {
        $this->cname = $cname;
    }

    public function getData(): array
    {
        return [
            'cname' => $this->cname,
        ];
    }
}
