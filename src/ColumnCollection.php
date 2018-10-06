<?php

namespace Willishq\QueryGrid;
/**
 * Class ColumnCollection
 * @package Willishq\DataGrid
 *
 * @property ColumnCollection $filterable
 * @property ColumnCollection $queryable
 * @property ColumnCollection $sortable
 * @property array $filterableKeys
 * @property array $queryableKeys
 * @property array $sortableKeys
 * @property array $keys
 */
class ColumnCollection extends Collection
{
    public function add(Column $column)
    {
        $this->items->append($column);
    }

    public function get(int $index): Column
    {
        return $this->items->offsetGet($index);
    }

    public function getByKey($key): Column
    {
        return $this->filter(function(Column $c) use ($key) {
            return $c->getKey() === $key;
        })->get(0);
    }

    public function hasQuery(): bool
    {
        return $this->queryable->count() > 0;
    }

    public function hasSorts(): bool
    {
        return $this->sortable->count() > 0;
    }

    public function hasFilters(): bool
    {
        return $this->filterable->count() > 0;
    }

    public function isFilterableKey(string $key): bool
    {
        return in_array($key, $this->filterableKeys);
    }

    public function isSortableKey(string $key): bool
    {
        return in_array(trim($key, '-'), $this->sortableKeys);
    }

    public function isQueryableKey(string $key)
    {
        return in_array($key, $this->queryableKeys);
    }

    public function getFilterable(): ColumnCollection
    {
        return $this->filter(function(Column $c) {
            return $c->isFilterable();
        });
    }

    public function getSortable(): ColumnCollection
    {
        return $this->filter(function(Column $c) {
            return $c->isSortable();
        });
    }

    public function getQueryable(): ColumnCollection
    {
        return $this->filter(function(Column $c) {
            return $c->isQueryable();
        });
    }

    public function getFilterableKeys(): array
    {
        return $this->filterable->keys;
    }

    public function getSortableKeys(): array
    {
        return $this->sortable->keys;
    }

    public function getQueryableKeys(): array
    {
        return $this->queryable->keys;
    }

    public function getKeys(): array
    {
        return $this->map(function(Column $column) {
            return $column->getKey();
        });
    }

    public function __get(string $name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return ($this->$method());
        }
        return null;
    }

    public function toArray(): array
    {
        return $this->map(function(Column $c) {
            return [
                'key' => $c->getKey(),
                'label' => $c->getLabel(),
                'sortable' => $c->isSortable(),
                'filterable' => $c->isFilterable(),
                'queryable' => $c->isQueryable(),
            ];
        });
    }

}
