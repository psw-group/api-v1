<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a known country.
 */
class Country extends AbstractResource
{
    /**
     * @var string 2 letter country code as defined by ISO-3166
     */
    private string $iso2;

    public function getIso2(): string
    {
        return $this->iso2;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->iso2 = $resource->getProperty('iso2');

        return $result;
    }

    /**
     * @param array{iri?: string|null, iso2?: string|null} $data
     */
    public static function fromArray(array $data): self
    {
        $result = new self();

        $result->setIri($data['iri'] ?? null);

        $result->iso2 = $data['iso2'] ?? '';

        return $result;
    }
}
