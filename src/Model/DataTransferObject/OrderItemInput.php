<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\DataTransferObject;

use PswGroup\Api\Model\Resource\Product;

class OrderItemInput implements \JsonSerializable
{
    /**
     * @var Product
     */
    private $product;

    /**
     * @var CertificateRequest|null
     */
    private $certificateRequest;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getCertificateRequest(): ?CertificateRequest
    {
        return $this->certificateRequest;
    }

    public function setCertificateRequest(?CertificateRequest $certificateRequest): void
    {
        $this->certificateRequest = $certificateRequest;
    }

    /**
     * @return array<string, string|CertificateRequest|null>
     */
    public function jsonSerialize(): array
    {
        return [
            'product' => $this->product->getIri(),
            'certificateRequest' => $this->certificateRequest,
        ];
    }
}
