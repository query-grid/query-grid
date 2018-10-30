<?php

namespace QueryGrid\QueryGrid\Collections;

use QueryGrid\QueryGrid\Contracts\Arrayable;
use QueryGrid\QueryGrid\Contracts\Collection as CollectionContract;

use Closure;

abstract class CollectionAbstract implements CollectionContract
{
    /** @var \ArrayIterator */
    protected $items;

    /**
     * CollectionAbstract constructor.
     */
    public function __construct()
    {
        $this->items = new \ArrayIterator();
    }

    /**
     * @param array $items
     * @return void
     */
    protected function fill(array $items)
    {
        $this->items = new \ArrayIterator($items);
    }


    /**
     * @param mixed $offset
     * @return mixed
     */
    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    /**
     * @param Closure $callable
     * @return CollectionContract
     */
    public function map(Closure $callable): CollectionContract
    {
        $collection = new static();
        $collection->fill(array_map($callable, $this->all()));
        return $collection;
    }

    /**
     * @param Closure $callable
     * @return CollectionContract
     */
    public function filter(Closure $callable): CollectionContract
    {
        $collection = new static;
        $collection->fill(array_values(array_filter($this->all(), $callable)));
        return $collection;
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->items->getArrayCopy();
    }

    /**
     * @param Closure $key
     * @param Closure|null $value
     * @return array
     */
    public function keyBy(Closure $key, Closure $value = null): array
    {
        $items = [];
        foreach ($this->items as $item) {
            $itemValue = is_null($value) ? $item : $value($item);
            $items[$key($item)] = $itemValue;
        }

        return $items;
    }

    /**
     * @return CollectionContract
     */
    public function unique(): CollectionContract
    {
        $collection = new static();
        $collection->fill(array_values(array_unique($this->items->getArrayCopy())));
        return $collection;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return $this->offsetGet(0);
    }

    /**
     * @return mixed
     */
    public function last()
    {
        return $this->offsetGet($this->count() - 1);
    }

    /**
     * @param mixed $value
     * @return void
     */
    protected function append($value)
    {
        $this->items->append($value);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->items->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @throws CollectionException
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        throw CollectionException::canNotSetOnACollection();
    }

    /**
     * @param mixed $offset
     * @throws CollectionException
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw CollectionException::canNotUnsetOnACollection();
    }

    /**
     * @return int
     */
    public function count()
    {
        return $this->items->count();
    }

    /**
     * Converts a collection to an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->map(function ($item) {
            return ($item instanceof Arrayable) ? $item->toArray() : $item;
        })->all();
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return $this->items->current();
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->items->next();
    }

    /**
     * @return mixed
     */
    public function key()
    {
        return $this->items->key();
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return $this->items->valid();
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->items->rewind();
    }

    /**
     * Implodes the collection items.
     *
     * @param string   $separator
     * @param \Closure $callback
     *
     * @return string
     */
    public function implode($separator, $callback)
    {
        return implode($separator, $this->map($callback)->all());
    }
}
