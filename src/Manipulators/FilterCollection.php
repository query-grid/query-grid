<?php

namespace Willishq\QueryGrid\Manipulators;

use Willishq\QueryGrid\Collection;

class FilterCollection extends Collection
{
    public function add(Filter $filter)
    {
        $this->items->append($filter);
    }

    public function get(int $index): Filter
    {
        return $this->items->offsetGet($index);
    }
}
