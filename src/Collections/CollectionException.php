<?php

namespace QueryGrid\QueryGrid\Collections;

class CollectionException extends \RuntimeException
{
    public static function canNotUnsetOnACollection()
    {
        return new static('You can not unset a collection value that way.');
    }
    public static function canNotSetOnACollection()
    {
        return new static('You can not change a collection value that way.');
    }
}
