<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Collections\CollectionAbstract;

class RowCollection extends CollectionAbstract
{
    public function populate(array $rows)
    {
        $this->fill($rows);
    }
}
