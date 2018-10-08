<?php

namespace Willishq\QueryGrid;

use Closure;
use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Columns\ColumnCollection;

class GridResult
{
    /**
     * @var ColumnCollection
     */
    private $columns;
    /**
     * @var RowCollection
     */
    private $rows;

    public function __construct(ColumnCollection $columns)
    {
        $this->columns = $columns;
        $rows = new RowCollection();
    }

    /**
     * @return ColumnCollection
     */
    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    public function setData(array $rows)
    {
        $collection = new RowCollection();
        $collection->populate($rows);
        $this->rows = $collection;
    }

    public function getRows(): array
    {
        return $this->rows->map(function (array $row) {
            return $this->columns->keyBy(function (Column $column) {
                return $column->getKey();
            }, function (Column $column) use ($row) {
                return $this->getValue($column, $row[$column->getField()] ?? null);
            });
        })->all();
    }

    private function getValue(Column $column, $value)
    {
        if ($column->hasFormat()) {
            return $column->format($value);
        }
        return $value;
    }

}
