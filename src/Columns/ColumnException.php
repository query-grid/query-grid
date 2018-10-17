<?php

namespace QueryGrid\QueryGrid\Columns;

class ColumnException extends \RuntimeException
{
    /**
     * @return ColumnException
     */
    public static function canNotAddFilterWithDuplicateType()
    {
        return new static("You can only add one of each filter type to a column.");
    }
}
