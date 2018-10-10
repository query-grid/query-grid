<?php

namespace Willishq\QueryGrid\Collections;

use Willishq\QueryGrid\Contracts\Arrayable;
use Willishq\QueryGrid\Contracts\Collection as CollectionContract;

use Closure;

abstract class CollectionAbstract implements CollectionContract
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


    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function map(Closure $callable): CollectionContract
    {
        $collection = new static();
        $collection->fill(array_map($callable, $this->all()));
        return $collection;
    }

    public function filter(Closure $callable): CollectionContract
    {
        $collection = new static;
        $collection->fill(array_values(array_filter($this->all(), $callable)));
        return $collection;
    }

    public function all(): array
    {
        return $this->items->getArrayCopy();
    }

    public function keyBy(Closure $key, Closure $value = null): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $itemValue = is_null($value) ? $item : $value($item);
            $items[$key($item)] = $itemValue;
        }

        return $items;
    }

    public function unique(): CollectionContract
    {
        $collection = new static();
        $collection->fill(array_values(array_unique($this->items->getArrayCopy())));
        return $collection;
    }

    public function first()
    {
        return $this->offsetGet(0);
    }

    public function last()
    {
        return $this->offsetGet($this->count() - 1);
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

    public function toArray(): array
    {
        return $this->map(function ($item) {
            return ($item instanceof Arrayable) ? $item->toArray() : $item;
        })->all();
    }
}
