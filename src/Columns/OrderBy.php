<?php

namespace Willishq\QueryGrid\Columns;

class OrderBy
{
    private $field;
    private $descending = false;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function isDescending(): bool
    {
        return $this->descending;
    }

    public function setDescending($descending = false)
    {
        $this->descending = $descending;
    }
}
