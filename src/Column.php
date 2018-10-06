<?php

namespace Willishq\QueryGrid;

class Column
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $label;
    /**
     * @var bool
     */
    private $sortable = false;
    /**
     * @var bool
     */
    private $filterable = false;
    /**
     * @var bool
     */
    private $queryable = false;
    /**
     * @var callable|null
     */
    private $formatter;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function sortable(): self
    {
        $this->sortable = true;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function filterable(): self
    {
        $this->filterable = true;

        return $this;
    }

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    public function queryable(): self
    {
        $this->queryable = true;

        return $this;
    }

    public function isQueryable(): bool
    {
        return $this->queryable;
    }

    public function formatter(callable $formatter)
    {
        $this->formatter = $formatter;
    }

    public function format($value)
    {
        if (!is_null($this->formatter)) {
            return ($this->formatter)($value);
        }

        return $value;
    }
}
