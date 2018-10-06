<?php

namespace Willishq\QueryGrid\Manipulators;

use Willishq\QueryGrid\Contracts\Wildcardable;

class Query implements Wildcardable
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return trim($this->value, '*|');
    }

    public function hasWildcardPrefix(): bool
    {
        return strpos($this->value, '*|') === 0;
    }

    public function hasWildcardSuffix(): bool
    {
        return strpos(strrev($this->value), '*|') === 0;
    }
}
