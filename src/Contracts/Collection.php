<?php

namespace QueryGrid\QueryGrid\Contracts;

use Closure;

interface Collection extends \ArrayAccess, \Countable, Arrayable, \Iterator
{
    /**
     * @param Closure $callable
     * @return Collection
     */
    public function map(Closure $callable): Collection;

    /**
     * @param Closure $callable
     * @return Collection
     */
    public function filter(Closure $callable): Collection;

    /**
     * @return Collection
     */
    public function unique(): Collection;

    /**
     * @return array
     */
    public function all(): array;

    /**
     * @param mixed $index
     * @return mixed
     */
    public function get($index);

    /**
     * @param Closure $key
     * @param Closure|null $value
     * @return array
     */
    public function keyBy(Closure $key, Closure $value = null): array;
}
