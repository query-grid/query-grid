<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Contracts\Collection as CollectionContract;
use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;

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
        $this->rows = new RowCollection();
    }

    /**
     * @return ColumnCollection
     */
    public function getColumns(): ColumnCollection
    {
        return $this->columns;
    }

    public function setRows(array $rows)
    {
        $this->rows->populate($rows);
    }

    /**
     * @return CollectionContract|RowCollection
     */
    public function getRows(): CollectionContract
    {
        return $this->rows->map(function ($row) {
            return $this->columns->keyBy(function (Column $column) {
                return $column->getKey();
            }, function (Column $column) use ($row) {
                return $this->getValue($column, $row);
            });
        });
    }

    private function getValue(Column $column, $value)
    {
        $field = $column->getField();
        if (isset($value[$field])) {
            $value = $value[$field];
        } else {
            foreach (explode('.', $field) as $part) {
                if (!is_array($value) || !isset($value[$part])) {
                    return '';
                }
                $value = $value[$part];
            }
        }

        if ($column->hasFormat() && !is_null($value)) {
            return $column->format($value);
        }
        return $value;
    }
}
