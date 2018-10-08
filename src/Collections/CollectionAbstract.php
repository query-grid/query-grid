<?php

namespace Willishq\QueryGrid\Collections;

use Closure;

abstract class CollectionAbstract implements \ArrayAccess, \Countable
{
    protected $items;

    public function __construct()
    {
        $this->items = new \ArrayIterator();
    }

    protected function fill(array $items)
    {
        $this->items = new \ArrayIterator($items);
    }

    public function map(callable $callable): Collection
    {
        $collection = new Collection();
        $collection->fill(array_map($callable, $this->all()));
        return $collection;
    }

    public function filter(callable $callable): CollectionAbstract
    {
        $collection = new static;
        $collection->fill(array_filter($this->all(), $callable));
        return $collection;
    }

    public function all(): array
    {
        return $this->items->getArrayCopy();
    }

    public function keyBy(Closure $keyCallable, Closure $valueCallable = null): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$keyCallable($item)] = is_null($valueCallable) ? $item : $valueCallable($item);
        }

        return $items;
    }

    protected function append($value)
    {
        $this->items->append($value);
    }

    public function offsetExists($offset)
    {
        return $this->items->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->items->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        throw CollectionException::canNotSetOnACollection();
    }

    public function offsetUnset($offset)
    {
        throw CollectionException::canNotUnsetOnACollection();
    }

    public function count()
    {
        return $this->items->count();
    }
}
