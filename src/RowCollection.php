<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Collections\CollectionAbstract;

class RowCollection extends CollectionAbstract
{
    public function populate(array $rows)
    {
        $this->fill($rows);
    }
}
