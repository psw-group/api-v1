<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

/**
 * Represents the data for HTTP or HTTPS validation.
 */
class CertificateValidationDataHttp extends CertificateValidationData
{
    private string $url;

    private ?string $content = null;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): void
    {
        $this->content = $content;
    }

    public function getData(): array
    {
        return [
            'url' => $this->url,
            'content' => $this->content,
        ];
    }
}
