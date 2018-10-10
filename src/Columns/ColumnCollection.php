<?php

namespace Willishq\QueryGrid\Columns;

use Closure;
use Willishq\QueryGrid\Collections\CollectionAbstract;

class ColumnCollection extends CollectionAbstract
{
    public function add(Column $column)
    {
        $this->append($column);
    }

    public function last(): Column
    {
        return $this->offsetGet($this->count() - 1);
    }

    public function first(): Column
    {
        return $this->offsetGet(0);
    }

    public function toArray(): array
    {
        return $this->map(function (Column $column) {
            return $column->toArray();
        })->all();
    }

    public function getAllFilters()
    {
        $filters = [];
        foreach ($this->items as $item) {
            $filters = array_merge($filters, $item->getFilters());
        }
        return $filters;
    }
}
