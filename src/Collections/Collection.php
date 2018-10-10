<?php

namespace Willishq\QueryGrid\Collections;

class Collection extends CollectionAbstract
{
    public function add($value)
    {
        $this->append($value);
    }
}
