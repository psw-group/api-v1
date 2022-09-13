<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

use ArrayAccess;
use ArrayIterator;
use BadMethodCallException;
use Countable;
use IteratorAggregate;

/**
 * Represents a collection of resources.
 *
 * @template TKey of int
 * @template TValue of AbstractResource|object
 *
 * @implements IteratorAggregate<TKey, TValue>
 * @implements ArrayAccess<TKey, TValue>
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /**
     * @var array<TKey, TValue>
     */
    private array $items = [];

    /**
     * Constructs an instance of this class.
     *
     * @param array<TKey, TValue> $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param TKey $offset
     */
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]) || array_key_exists($offset, $this->items);
    }

    /**
     * @param TKey $offset
     *
     * @return TValue|null
     */
    public function offsetGet($offset): ?object
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @param TKey   $offset
     * @param TValue $value
     */
    public function offsetSet($offset, $value): void
    {
        throw new BadMethodCallException(sprintf('Array access of class %s is read-only.', static::class));
    }

    /**
     * @param TKey $offset
     */
    public function offsetUnset($offset): void
    {
        throw new BadMethodCallException(sprintf('Array access of class %s is read-only.', static::class));
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return ArrayIterator<TKey, TValue>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    /**
     * @return array<TKey, TValue>
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
