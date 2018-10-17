<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Collections\CollectionAbstract;

class RowCollection extends CollectionAbstract
{
    /**
     * @param array $rows
     * @return void
     */
    public function populate(array $rows)
    {
        $this->fill($rows);
    }
}
