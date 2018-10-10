<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Collections\CollectionAbstract;

class RowCollection extends CollectionAbstract
{
    public function populate(array $rows)
    {
        $this->fill($rows);
    }

    public function map(callable $callable): CollectionAbstract
    {
        $rows = new static();
        $rows->fill(array_map($callable, $this->all()));
        return $rows;
    }
}
