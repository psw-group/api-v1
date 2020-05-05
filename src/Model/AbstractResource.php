<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

abstract class AbstractResource
{
    /**
     * @var string|null
     */
    private $iri;

    public function getIri(): ?string
    {
        return $this->iri;
    }

    public function setIri(?string $iri): void
    {
        $this->iri = $iri;
    }

    /**
     * @return static
     */
    public static function fromResource(HalResource $resource)
    {
        $result = new static();

        if ($resource->hasLink('self') && $resource->getFirstLink('self')) {
            $result->iri = $resource->getFirstLink('self')->getUri();
        }

        return $result;
    }

    protected static function loadDateTime(HalResource $resource, string $property): ?DateTimeInterface
    {
        if (! $resource->hasProperty($property) || $resource->getProperty($property) === null) {
            return null;
        }

        return new DateTime($resource->getProperty($property));
    }

    protected static function loadObject(HalResource $resource, string $property, string $className)
    {
        if ($resource->hasResource($property)) {
            return call_user_func([$className, 'fromResource'], $resource->getFirstResource($property));
        }

        if (! $resource->hasProperty($property) || $resource->getProperty($property) === null) {
            return null;
        }

        $data = $resource->getProperty($property);

        if ($data instanceof HalResource) {
            return call_user_func([$className, 'fromResource'], $data);
        }

        if (! is_array($data)) {
            throw new InvalidArgumentException(sprintf('Expected an array but got %s.', gettype($data)));
        }

        return call_user_func([$className, 'fromArray'], $data);
    }
}
