<?php

namespace Willishq\QueryGrid\Manipulators;

use Willishq\QueryGrid\Contracts\Wildcardable;

class Filter implements Wildcardable
{
    /** @var string */
    protected $field;
    /** @var string */
    protected $value;

    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return trim($this->value, ':*><|');
    }

    public function hasWildcardPrefix(): bool
    {
        return strpos($this->value, '*|') === 0;
    }

    public function hasWildcardSuffix(): bool
    {
        return strpos(strrev($this->value), '*|') === 0;
    }

    public function hasGreaterThan()
    {
        return strpos($this->value, '>|') === 0;
    }

    public function hasLessThan()
    {
        return strpos($this->value, '<|') === 0;
    }

    public function hasGreaterOrEqual()
    {
        return strpos($this->value, '>:|') === 0;
    }

    public function hasLessOrEqual()
    {
        return strpos($this->value, '<:|') === 0;
    }
}
