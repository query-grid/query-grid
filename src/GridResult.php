<?php

namespace QueryGrid\QueryGrid;

use ArrayAccess;
use QueryGrid\QueryGrid\Contracts\Collection as CollectionContract;
use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;

class GridResult
{
    /** @var ColumnCollection */
    private $columns;
    /** @var RowCollection */
    private $rows;

    /**
     * GridResult constructor.
     * @param ColumnCollection $columns
     */
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

    /**
     * @param array $rows
     * @return void
     */
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

    /**
     * @param Column $column
     * @param mixed $value
     * @return mixed|string
     */
    private function getValue(Column $column, $value)
    {
        $field = $column->getField();
        if (isset($value[$field])) {
            $value = $value[$field];
        } else {
            foreach (explode('.', $field) as $part) {
                if (($value instanceof ArrayAccess || is_array($value)) && isset($value[$part])) {
                    $value = $value[$part];
                } else {
                    return '';
                }
            }
        }
        return $column->format($value);
    }
}
