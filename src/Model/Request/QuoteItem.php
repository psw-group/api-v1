<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Request;

use JsonSerializable;
use PswGroup\Api\Model\Resource\Product;

class QuoteItem implements JsonSerializable
{
    /**
     * @var Product Product which should be included
     */
    private Product $product;

    /**
     * @var CertificateData|null Data for the certificate which should be included
     */
    private ?CertificateData $certificateData = null;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getCertificateData(): ?CertificateData
    {
        return $this->certificateData;
    }

    public function setCertificateData(?CertificateData $certificateRequest): void
    {
        $this->certificateData = $certificateRequest;
    }

    /**
     * @return array{product: string|null, certificateRequest: CertificateData|null}
     */
    public function jsonSerialize(): array
    {
        return [
            'product' => $this->product->getIri(),
            'certificateRequest' => $this->certificateData,
        ];
    }
}
