<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

class CertificateValidationDataDnsTxt extends CertificateValidationData
{
    /**
     * @var string
     */
    private $dnstxt;

    public function getDnstxt(): string
    {
        return $this->dnstxt;
    }

    public function setDnstxt(string $dnstxt): void
    {
        $this->dnstxt = $dnstxt;
    }

    public function getData(): array
    {
        return [
            'dnstxt' => $this->dnstxt,
        ];
    }
}
