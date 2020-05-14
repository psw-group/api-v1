<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

use ArrayIterator;

/**
 * Represents a collection of resources.
 */
class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array<int, AbstractResource|object>
     */
    private $items;

    /**
     * Constructs an instance of this class.
     *
     * @param array<int, AbstractResource|object> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param mixed|null $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]) || array_key_exists($offset, $this->items);
    }

    /**
     * @param mixed|null $offset
     *
     * @return AbstractResource|object|null
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @param mixed|null $offset
     * @param mixed|null $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new \BadMethodCallException(sprintf('Array access of class %s is read-only.', static::class));
    }

    /**
     * @param mixed|null $offset
     */
    public function offsetUnset($offset): void
    {
        throw new \BadMethodCallException(sprintf('Array access of class %s is read-only.', static::class));
    }

    public function count(): int
    {
        return \count($this->items);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return array<int, AbstractResource|object>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
