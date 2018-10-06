<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Manipulators\Filter;

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
     * @var Callable|null
     */
    private $formatter;
    /**
     * @var string
     */
    private $filter;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->label = $label;
        $this->filter = [Filter::class, 'create'];
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

    public function formatter(Callable $formatter)
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
