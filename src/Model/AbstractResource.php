<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

use BinSoul\Net\Hal\Client\HalResource;
use DateTime;
use DateTimeInterface;
use InvalidArgumentException;
use Throwable;

abstract class AbstractResource
{
    private ?string $iri = null;

    /**
     * Constructs an instance of this class.
     */
    final public function __construct()
    {
    }

    public function getIri(): ?string
    {
        return $this->iri;
    }

    public function setIri(?string $iri): void
    {
        $this->iri = $iri;
    }

    public static function fromResource(HalResource $resource): static
    {
        $result = new static();

        if ($resource->hasLink('self') && ($link = $resource->getFirstLink('self'))) {
            $result->iri = $link->getUri();
        }

        return $result;
    }

    public static function loadDateTime(HalResource $resource, string $property): ?DateTimeInterface
    {
        if (! $resource->hasProperty($property) || $resource->getProperty($property) === null || ! is_string($resource->getProperty($property))) {
            return null;
        }

        try {
            return new DateTime($resource->getProperty($property));
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $className
     *
     * @return T
     */
    public static function loadObject(HalResource $resource, string $property, string $className): ?object
    {
        $callable = [$className, 'fromResource'];

        if ($resource->hasResource($property)) {
            if (! is_callable($callable)) {
                return null;
            }

            $result = call_user_func($callable, $resource->getFirstResource($property));

            if ($result instanceof $className) {
                return $result;
            }

            return null;
        }

        if (! $resource->hasProperty($property) || $resource->getProperty($property) === null) {
            return null;
        }

        $data = $resource->getProperty($property);

        if ($data instanceof HalResource) {
            if (! is_callable($callable)) {
                return null;
            }

            $result = call_user_func($callable, $data);

            if ($result instanceof $className) {
                return $result;
            }

            return null;
        }

        if (! is_array($data)) {
            throw new InvalidArgumentException(sprintf('Expected an array but got %s.', gettype($data)));
        }

        $callable = [$className, 'fromArray'];

        if (! is_callable($callable)) {
            return null;
        }

        $result = call_user_func($callable, $data);

        if ($result instanceof $className) {
            return $result;
        }

        return null;
    }
}
