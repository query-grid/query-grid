<?php

namespace Willishq\QueryGrid\Contracts;

use Closure;

interface Collection extends \ArrayAccess, \Countable
{
    public function map(Closure $callable): Collection;

    public function filter(Closure $callable): Collection;

    public function all(): array;

    public function get($index);

    public function keyBy(Closure $key, Closure $value = null): array;
}
