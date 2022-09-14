<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

/**
 * Represents the data for DNSTXT validation.
 */
class CertificateValidationDataDnsTxt extends CertificateValidationData
{
    private string $dnstxt;

    public function getDnstxt(): string
    {
        return $this->dnstxt;
    }

    public function setDnstxt(string $dnstxt): void
    {
        $this->dnstxt = $dnstxt;
    }

    /**
     * @return array{dnstxt: string}
     */
    public function getData(): array
    {
        return [
            'dnstxt' => $this->dnstxt,
        ];
    }
}
