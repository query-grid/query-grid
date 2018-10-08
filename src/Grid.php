<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Columns\ColumnCollection;
use Willishq\QueryGrid\Contracts\DataProvider;

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

    public function __construct(DataProvider $dataProvider, array $queryParams = [])
    {

        $this->dataProvider = $dataProvider;
        $this->queryParams = $queryParams;
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
     * @return array
     */
    public function getQueryParams(): array
    {
        return $this->queryParams;
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

    public function getResult(): GridResult
    {
        $result = new GridResult($this->columns);

        $result->setData($this->dataProvider->get());

        return $result;
    }

}
