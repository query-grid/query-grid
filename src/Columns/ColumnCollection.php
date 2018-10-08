<?php

namespace Willishq\QueryGrid\Columns;

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
}
