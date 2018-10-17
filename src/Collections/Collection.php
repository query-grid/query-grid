<?php

namespace QueryGrid\QueryGrid\Collections;

class Collection extends CollectionAbstract
{
    /**
     * @param mixed $value
     * @return void
     */
    public function add($value)
    {
        $this->append($value);
    }
}
