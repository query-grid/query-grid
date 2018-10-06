<?php

namespace Willishq\QueryGrid\Manipulators;

class Sort
{
    /**
     * @var string
     */
    private $field;

    public function __construct(string $field)
    {
        $this->field = $field;
    }

    public function descending(): bool
    {
        return strpos($this->field, '-') === 0;
    }

    public function field(): string
    {
        return trim($this->field, '-');
    }
}
