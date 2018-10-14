<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;
use QueryGrid\QueryGrid\Columns\Filter;
use QueryGrid\QueryGrid\Contracts\DataProvider;

class Grid
{
    /**
     * @var DataProvider
     */
    private $dataProvider;
    /**
     * @var ColumnCollection
     */
    private $columns;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
        $this->columns = new ColumnCollection();
    }

    /**
     * @return DataProvider
     */
    public function getDataProvider(): DataProvider
    {
        return $this->dataProvider;
    }

    public function addColumn(string $key, string $label): Column
    {
        $column = new Column($key, $label);
        $this->columns->add($column);
        return $column;
    }

    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    public function setResource(string $resource)
    {
        $this->dataProvider->setResource($resource);
    }

    public function getResult($params = []): GridResult
    {
        if (array_key_exists('filters', $params)) {
            $this->setFilters($params['filters']);
        }

        if (array_key_exists('query', $params)) {
            $this->setQuery($params['query']);
        }

        if (array_key_exists('sort', $params)) {
            $this->setOrderBy($params['sort']);
        }

        $result = new GridResult($this->columns);

        $result->setRows($this->dataProvider->get());

        return $result;
    }

    private function setFilters($filters)
    {
        $newFilters = [];
        /** @var Filter[] $allFilters */
        $allFilters = $this->columns->getAllFilters();
        foreach ($filters as $key => $value) {
            if (!array_key_exists($key, $allFilters)) {
                continue;
            }
            $filter = $allFilters[$key];

            if (!array_key_exists($filter->getField(), $newFilters)) {
                $newFilters[$filter->getField()] = [];
            }

            $newFilters[$filter->getField()][] = [
                'type' => $filter->getType(),
                'value' => $value,
            ];
        }
        $this->dataProvider->setFilters($newFilters);
    }

    private function setQuery($query)
    {
        $columns = $this->columns->getQueryableColumns()
            ->map(function (Column $column) {
                return $column->getField();
            })->unique();
        $this->dataProvider->setQuery(new Query($query, $columns->all()));
    }

    private function setOrderBy($orderByQuery)
    {
        $orderByList = explode(',', $orderByQuery);
        $descending = [];
        foreach ($orderByList as $orderBy) {
            $key = ltrim($orderBy, '-');
            $descending[$key] = $orderBy !== $key;
        }

        $sortableColumns = $this->columns->filter(function (Column $column) use ($descending) {
            return array_key_exists($column->getKey(), $descending);
        });

        foreach ($sortableColumns as $column) {
            /** @var Column $column */
            $column->setOrderBy($descending[$column->getKey()]);
            $this->dataProvider->addOrderBy($column->getOrderBy());
        }
    }
}
