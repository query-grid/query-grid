<?php

namespace Willishq\QueryGrid\Manipulators;

use Willishq\QueryGrid\Collection;

class SortCollection extends Collection
{
    public function add(Sort $sort)
    {
        $this->items->append($sort);
    }

    public function get(int $index): Sort
    {
        return $this->items->offsetGet($index);
    }
}
