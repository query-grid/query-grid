<?php

namespace Willishq\QueryGrid\Contracts;

use Willishq\QueryGrid\Query;

interface DataProvider
{
    public function setResource(string $resource);

    public function get(): array;

    public function setFilters(array $filters);

    public function setQuery(Query $query);
}
