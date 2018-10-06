<?php

namespace Willishq\QueryGrid\Contracts;

interface Wildcardable
{
    public function hasWildcardPrefix(): bool;

    public function hasWildcardSuffix(): bool;

    public function getValue();
}
