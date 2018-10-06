<?php

namespace Willishq\QueryGrid;

use ArrayAccess;
use Countable;

class Collection implements Countable
{
    /**
     * @var \ArrayIterator
     */
    protected $items;

    public function __construct($items = [])
    {
        $this->items = new \ArrayIterator($items);
    }

    public function all(): array
    {
        return $this->items->getArrayCopy();
    }

    public function count()
    {
        return $this->items->count();
    }

    public function filter(Callable $cb)
    {
        return new static(array_values(array_filter($this->all(), $cb)));
    }

    public function map(Callable $callable, ...$additional)
    {
        return array_map(function ($item) use ($callable, $additional) {
            return $callable($item, ...$additional);
        }, $this->all());
    }

    public function keyBy(Callable $cb)
    {
        $items = [];
        foreach ($this->items as $item) {
            $items[$cb($item)] = $item;
        }
        return new static($items);
    }
}
