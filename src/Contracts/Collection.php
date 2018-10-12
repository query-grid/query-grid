<?php

namespace Willishq\QueryGrid\Contracts;

use Closure;

interface Collection extends \ArrayAccess, \Countable, Arrayable, \Iterator
{
    public function map(Closure $callable): Collection;

    public function filter(Closure $callable): Collection;

    public function unique(): Collection;

    public function all(): array;

    public function get($index);

    public function keyBy(Closure $key, Closure $value = null): array;
}
