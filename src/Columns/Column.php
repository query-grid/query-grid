<?php

namespace QueryGrid\QueryGrid\Columns;

class Column
{
    /** @var string */
    private $key;
    /** @var string */
    private $label;
    /** @var string */
    private $field;
    /** @var callable|null */
    private $formatter;
    /** @var array  */
    private $filters = [];
    /** @var bool  */
    private $sortable = false;
    /** @var bool  */
    private $queryable = false;
    /** @var OrderBy|null */
    private $orderBy;

    /**
     * Column constructor.
     * @param string $key
     * @param string $label
     */
    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->field = $key;
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $field
     * @return Column
     */
    public function fromField(string $field): self
    {
        $this->field = $field;
        array_walk($this->filters, function (Filter $filter) {
            $filter->setField($this->field);
        });
        return $this;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param callable $callable
     * @return Column
     */
    public function withFormat(callable $callable): self
    {
        $this->formatter = $callable;
        return $this;
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    public function format($value)
    {
        if (is_callable($this->formatter)) {
            $value = ($this->formatter)($value);
        }
        return $value;
    }

    /**
     * @return bool
     */
    public function hasFormat()
    {
        return isset($this->formatter);
    }

    /**
     * @param string $type
     * @param string $name
     * @return Filter
     */
    public function addFilter(string $type, string $name = ''): Filter
    {
        $key = $this->getKey() . '.' . $type;
        if (array_key_exists($key, $this->filters)) {
            throw ColumnException::canNotAddFilterWithDuplicateType();
        }
        $filter = new Filter($type);
        $filter->setName($name);
        $filter->setField($this->field);
        $this->filters[$key] = $filter;
        return $filter;
    }

    /**
     * @return array
     */
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

        if (count($filters) > 0) {
            $result['filters'] = $filters;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return void
     */
    public function sortable()
    {
        $this->sortable = true;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }

    /**
     * @return void
     */
    public function queryable()
    {
        $this->queryable = true;
    }

    /**
     * @return bool
     */
    public function isQueryable(): bool
    {
        return $this->queryable;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return count($this->filters) > 0;
    }

    /**
     * @param bool $descending
     * @return void
     */
    public function setOrderBy($descending = false)
    {
        $this->orderBy = new OrderBy($this->getField());
        $this->orderBy->setDescending($descending);
    }

    /**
     * @return null|OrderBy
     */
    public function getOrderBy(): ?OrderBy
    {
        return $this->orderBy;
    }
}
