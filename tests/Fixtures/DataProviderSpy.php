<?php

namespace Tests\Fixtures;

use Willishq\QueryGrid\Columns\OrderBy;
use Willishq\QueryGrid\Contracts\DataProvider;
use Willishq\QueryGrid\Query;

class DataProviderSpy implements DataProvider
{
    private $resource;

    public $values = [];
    private $filters = [];
    private $query;
    private $orderBy = [];

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource)
    {
        $this->resource = $resource;
    }

    public function setValues($data)
    {
        $this->values = $data;
    }

    public function get(): array
    {
        return $this->values;
    }

    public function setFilters(array $filters)
    {
        $this->filters = $filters;
    }

    public function getFilters()
    {
        return $this->filters;
    }

    public function setQuery(Query $query)
    {
        $this->query = $query;
    }

    public function getQuery(): ?Query
    {
        return $this->query;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }

    public function addOrderBy(OrderBy $orderBy)
    {
        $this->orderBy[] = $orderBy;
    }
}
