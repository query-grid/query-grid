<?php

namespace Willishq\QueryGrid\Columns;

class ColumnException extends \RuntimeException
{
    public static function canNotAddFilterWithDuplicateType()
    {
        return new static("You can not add more than one filter of each type to a column.");
    }
}
