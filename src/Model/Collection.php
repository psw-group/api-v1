<?php

declare(strict_types=1);

namespace PswGroup\Api\Model;

/**
 * Represents a collection of resources.
 */
class Collection implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var AbstractResource[]
     */
    private $items;

    /**
     * Constructs an instance of this class.
     *
     * @param AbstractResource[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * Required by interface ArrayAccess.
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]) || array_key_exists($offset, $this->items);
    }

    /**
     * Required by interface ArrayAccess.
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * Required by interface ArrayAccess.
     */
    public function offsetSet($offset, $value)
    {
        throw new \BadMethodCallException(sprintf('Array access of class %s is read-only.', get_class($this)));
    }

    /**
     * Required by interface ArrayAccess.
     */
    public function offsetUnset($offset)
    {
        throw new \BadMethodCallException(sprintf('Array access of class %s is read-only.', get_class($this)));
    }

    /**
     * Required by interface Countable.
     */
    public function count()
    {
        return \count($this->items);
    }

    /**
     * Required by interface IteratorAggregate.
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * @return AbstractResource[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
