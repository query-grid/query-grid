<?php

namespace Willishq\QueryGrid\Collections;

class Collection extends CollectionAbstract
{
    public function add($value)
    {
        $this->append($value);
    }

    public function get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function first()
    {
        return $this->offsetGet(0);
    }

    public function last()
    {
        return $this->offsetGet($this->count() - 1);
    }
}
