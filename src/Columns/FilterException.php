<?php

namespace QueryGrid\QueryGrid\Columns;

class FilterException extends \RuntimeException
{
    /**
     * @param string $type
     * @return FilterException
     */
    public static function unknownFilterType(string $type)
    {
        return new static("Trying to set an unknown filter type: {$type}");
    }
}
