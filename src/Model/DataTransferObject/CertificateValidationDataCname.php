<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

/**
 * Represents the data for CNAME validation.
 */
class CertificateValidationDataCname extends CertificateValidationData
{
    private string $cname;

    public function getCname(): string
    {
        return $this->cname;
    }

    public function setCname(string $cname): void
    {
        $this->cname = $cname;
    }

    /**
     * @return array{cname: string}
     */
    public function getData(): array
    {
        return [
            'cname' => $this->cname,
        ];
    }
}
