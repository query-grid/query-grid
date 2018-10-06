<?php

namespace Willishq\QueryGrid\Contracts;

use Willishq\QueryGrid\Collection;
use Willishq\QueryGrid\ColumnCollection;
use Willishq\QueryGrid\Manipulators\Filter;
use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGrid\Manipulators\Sort;

interface DataProvider
{
    /**
     * @param PaginationData $paginator
     * @return Collection
     */
    public function get(PaginationData $paginator): Collection;

    /**
     * @param Filter $filter
     * @return mixed
     */
    public function addFilter(Filter $filter);

    /**
     * @param Query $query
     * @return mixed
     */
    public function addQuery(Query $query);

    /**
     * @param Sort $sorts
     * @return mixed
     */
    public function addSort(Sort $sorts);

    /**
     * @param string $resource
     * @return mixed
     */
    public function setResource(string $resource);

    /**
     * @param ColumnCollection $columns
     * @return mixed
     */
    public function setColumns(ColumnCollection $columns);
}
