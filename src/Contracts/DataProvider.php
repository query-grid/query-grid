<?php

namespace QueryGrid\QueryGrid\Contracts;

use QueryGrid\QueryGrid\Columns\OrderBy;
use QueryGrid\QueryGrid\Query;

interface DataProvider
{
    /**
     * @param string $resource
     * @return mixed
     */
    public function setResource(string $resource);

    /**
     * @return array
     */
    public function get(): array;

    /**
     * @param array $filters
     * @return mixed
     */
    public function setFilters(array $filters);

    /**
     * @param Query $query
     * @return mixed
     */
    public function setQuery(Query $query);

    /**
     * @param OrderBy $orderBy
     * @return mixed
     */
    public function addOrderBy(OrderBy $orderBy);
}
