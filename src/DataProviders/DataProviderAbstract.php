<?php

namespace Willishq\QueryGrid\DataProviders;

use Willishq\QueryGrid\ColumnCollection;
use Willishq\QueryGrid\Contracts\DataProvider;
use Willishq\QueryGrid\Manipulators\Filter;
use Willishq\QueryGrid\Manipulators\FilterCollection;
use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGrid\Manipulators\Sort;
use Willishq\QueryGrid\Manipulators\SortCollection;

abstract class DataProviderAbstract implements DataProvider
{
    /**
     * @var FilterCollection
     */
    protected $filters;
    /**
     * @var Query
     */
    protected $query;
    /**
     * @var SortCollection
     */
    protected $sorts;
    /**
     * @var string
     */
    protected $resource;
    /**
     * @var ColumnCollection
     */
    protected $columns;

    public function __construct()
    {
        $this->filters = new FilterCollection();
        $this->sorts = new SortCollection();
    }

    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    public function addFilter(Filter $filter)
    {
        $this->filters->add($filter);
    }

    public function addQuery(Query $query)
    {
        $this->query = $query;
    }

    public function addSort(Sort $sort)
    {
        $this->sorts->add($sort);
    }

    public function setResource(string $resource)
    {
        $this->resource = $resource;
    }
}
