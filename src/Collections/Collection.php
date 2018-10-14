<?php

namespace QueryGrid\QueryGrid\Collections;

class Collection extends CollectionAbstract
{
    public function add($value)
    {
        $this->append($value);
    }
}
