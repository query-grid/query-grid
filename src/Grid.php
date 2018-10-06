<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Contracts\DataProvider;
use Willishq\QueryGrid\DataProviders\Pagination\PaginationData;
use Willishq\QueryGrid\Exceptions\ColumnKeyNotInRowException;
use Willishq\QueryGrid\Exceptions\ColumnNotFilterableException;
use Willishq\QueryGrid\Exceptions\ColumnNotSortableException;
use Willishq\QueryGrid\Manipulators\Filter;
use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGrid\Manipulators\Sort;

/**
 */
class Grid
{
    /**
     * @var DataProvider
     */
    private $dataProvider;
    /**
     * @var array
     */
    private $queryParams;
    /**
     * @var ColumnCollection
     */
    private $columns;
    private $sortable = false;
    private $queryable = false;
    private $filterable = false;
    private $result;


    public function __construct(DataProvider $dataProvider, $queryParams = [])
    {
        $this->dataProvider = $dataProvider;
        $this->queryParams = $queryParams;
        $this->columns = new ColumnCollection();
    }

    public function addQueryParams($queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * @return GridResult
     * @throws \Exception
     */
    public function getResults(): GridResult
    {
        if (is_null($this->result)) {
            $this->parseFilters();
            $this->parseQuery();
            $this->parseSorts();
            $this->dataProvider->setColumns($this->columns);

            $paginationData = new PaginationData($this->queryParams['perPage'] ?? 25, $this->queryParams['page'] ?? 1);
            $data = $this->dataProvider->get($paginationData)->map(function ($row) {
                return $this->columns->keyBy(function (Column $c) {
                    return $c->getKey();
                })->map(function ($column, $row) {
                    return $this->getColumnValueFromDataRow($column, (array)$row);
                }, $row);
            });
            $this->result = new GridResult($paginationData, $data, $this->columns);
        }
        return $this->result;
    }

    private function getColumnValueFromDataRow(Column $c, array $row)
    {
        if (!array_key_exists($c->getKey(), $row)) {
            throw new ColumnKeyNotInRowException();
        }
        return $c->format($row[$c->getKey()]);
    }

    public function addColumn(string $key, string $label, Callable $callable = null): self
    {
        $column = new Column($key, $label);

        if (!is_null($callable)) {
            ($callable)($column);
        }
        $this->sortable = $column->isSortable() || $this->sortable;
        $this->queryable = $column->isQueryable() || $this->queryable;
        $this->filterable = $column->isFilterable() || $this->filterable;
        $this->columns->add($column);
        return $this;
    }

    public function setResource(string $resource)
    {
        $this->dataProvider->setResource($resource);
    }

    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function isQueryable(): bool
    {
        return $this->queryable;
    }

    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    protected function parseFilters()
    {
        if (isset($this->queryParams['filter'])) {
            foreach ($this->queryParams['filter'] as $key => $value) {
                $column = $this->columns->getByKey($key);
                if ($column->isFilterable()) {
                    foreach (explode(',', $value) as $result) {
                        $this->dataProvider->addFilter(new Filter($column->getKey(), $result));
                    }
                } else {
                    throw new ColumnNotFilterableException();
                }

            }
        }
    }

    protected function parseQuery()
    {
        if (isset($this->queryParams['query'])) {
            $this->dataProvider->addQuery(new Query($this->queryParams['query']));
        }
    }

    protected function parseSorts()
    {
        if (isset($this->queryParams['sort'])) {
            foreach (explode(',', $this->queryParams['sort']) as $field) {
                if (!$this->columns->isSortableKey($field)) {
                    throw new ColumnNotSortableException();
                }
                $this->dataProvider->addSort(new Sort($field));
            }
        }
    }
}
