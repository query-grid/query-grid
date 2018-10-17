<?php

namespace QueryGrid\QueryGrid\Columns;

class OrderBy
{
    /** @var string  */
    private $field;
    /** @var bool  */
    private $descending = false;

    /**
     * OrderBy constructor.
     * @param string $field
     */
    public function __construct(string $field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     * @return void
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return bool
     */
    public function isDescending(): bool
    {
        return $this->descending;
    }

    /**
     * @param bool $descending
     * @return void
     */
    public function setDescending($descending = false)
    {
        $this->descending = $descending;
    }
}
