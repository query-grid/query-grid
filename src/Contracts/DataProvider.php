<?php

namespace QueryGrid\QueryGrid\Contracts;

use QueryGrid\QueryGrid\Columns\OrderBy;
use QueryGrid\QueryGrid\Query;

interface DataProvider
{
    public function setResource(string $resource);

    public function get(): array;

    public function setFilters(array $filters);

    public function setQuery(Query $query);

    public function addOrderBy(OrderBy $orderBy);
}
