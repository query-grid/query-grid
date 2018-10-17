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

    /**
     * Grid constructor.
     * @param DataProvider $dataProvider
     */
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

    /**
     * @param string $key
     * @param string $label
     * @return Column
     */
    public function addColumn(string $key, string $label): Column
    {
        $column = new Column($key, $label);
        $this->columns->add($column);
        return $column;
    }

    /**
     * @return ColumnCollection
     */
    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    /**
     * @param string $resource
     * @return void
     */
    public function setResource(string $resource)
    {
        $this->dataProvider->setResource($resource);
    }

    /**
     * @param array $params
     * @return GridResult
     */
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

    /**
     * @param Filter[] $filters
     * @return void
     */
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

    /**
     * @param mixed $query
     * @return void
     */
    private function setQuery($query)
    {
        $columns = $this->columns->getQueryableColumns()
            ->map(function (Column $column) {
                return $column->getField();
            })->unique();
        $this->dataProvider->setQuery(new Query($query, $columns->all()));
    }

    /**
     * @param string $orderByQuery
     * @return void
     */
    private function setOrderBy(string $orderByQuery)
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
