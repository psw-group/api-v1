<?php

declare(strict_types=1);

namespace PswGroup\Api\Model\Resource;

use BinSoul\Net\Hal\Client\HalResource;
use PswGroup\Api\Model\AbstractResource;

/**
 * Represents a known organisation type.
 */
class OrganisationType extends AbstractResource
{
    /**
     * @var string Code of the type
     */
    private string $code;

    /**
     * @var string German name of the type
     */
    private string $name;

    public function getCode(): string
    {
        return $this->code;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = parent::fromResource($resource);

        $result->code = $resource->getProperty('code');
        $result->name = $resource->getProperty('name');

        return $result;
    }

    /**
     * @param array{iri?: string|null, code?: string|null, name?: string|null} $data
     */
    public static function fromArray(array $data): self
    {
        $result = new self();

        $result->setIri($data['iri'] ?? null);

        $result->code = $data['code'] ?? '';
        $result->name = $data['name'] ?? '';

        return $result;
    }
}
