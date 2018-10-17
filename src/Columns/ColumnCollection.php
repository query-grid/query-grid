<?php

namespace QueryGrid\QueryGrid\Columns;

use QueryGrid\QueryGrid\Contracts\Collection as CollectionContract;
use QueryGrid\QueryGrid\Collections\CollectionAbstract;

class ColumnCollection extends CollectionAbstract
{
    /**
     * @param Column $column
     * @return void
     */
    public function add(Column $column)
    {
        $this->append($column);
    }

    /**
     * @return Column
     */
    public function last(): Column
    {
        return $this->offsetGet($this->count() - 1);
    }

    /**
     * @return Column
     */
    public function first(): Column
    {
        return $this->offsetGet(0);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->map(function (Column $column) {
            return $column->toArray();
        })->all();
    }

    /**
     * @return array
     */
    public function getAllFilters()
    {
        $filters = [];
        foreach ($this->items as $item) {
            $filters = array_merge($filters, $item->getFilters());
        }
        return $filters;
    }

    /**
     * @return CollectionContract
     */
    public function getQueryableColumns(): CollectionContract
    {
        return $this->filter(function (Column $column) {
            return $column->isQueryable();
        });
    }

    /**
     * @return CollectionContract
     */
    public function getSortableColumns()
    {
        return $this->filter(function (Column $column) {
            return $column->isSortable();
        });
    }
}
