<?php

namespace Willishq\QueryGrid\Columns;

use Willishq\QueryGrid\Filter;

class Column
{
    private $key;
    private $label;
    private $field;
    private $formatter;
    private $filters = [];
    private $sortable = false;
    private $queryable = false;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->field = $key;
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    public function fromField(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function withFormat(callable $callable): self
    {
        $this->formatter = $callable;
        return $this;
    }

    public function format($value)
    {
        return ($this->formatter)($value);
    }

    public function hasFormat()
    {
        return isset($this->formatter);
    }

    public function addFilter(string $type, string $name = ''): Filter
    {
        $key = $this->getKey() . '.' . $type;
        if (array_key_exists($key, $this->filters)) {
            throw ColumnException::canNotAddFilterWithDuplicateType();
        }
        $filter = new Filter($type);
        $filter->setName($name);
        $this->filters[$key] = $filter;
        return $filter;
    }

    public function toArray(): array
    {
        $filters = [];

        foreach ($this->filters as $key => $filter) {
            $filters[$key] = $filter->toArray();
        }

        $result = [
            'key' => $this->getKey(),
            'label' => $this->getLabel(),
            'sortable' => $this->isSortable(),
            'queryable' => $this->isQueryable(),
            'filterable' => $this->isFilterable(),
        ];

        if (!empty($filters)) {
            $result['filters'] = $filters;
        }

        return $result;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function sortable()
    {
        $this->sortable = true;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function queryable()
    {
        $this->queryable = true;
    }

    public function isQueryable(): bool
    {
        return $this->queryable;
    }

    public function isFilterable(): bool
    {
        return !empty($this->filters);
    }
}
