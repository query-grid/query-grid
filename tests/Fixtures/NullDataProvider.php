<?php

namespace Willishq\QueryGridTests\Fixtures;

use Willishq\QueryGrid\Collection;
use Willishq\QueryGrid\Contracts\DataProvider;
use Willishq\QueryGrid\DataProviders\DataProviderAbstract;
use Willishq\QueryGrid\Contracts\PaginationData as PaginationDataContract;
use Willishq\QueryGrid\GridResult;
use Willishq\QueryGrid\Manipulators\FilterCollection;
use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGrid\Manipulators\SortCollection;

class NullDataProvider extends DataProviderAbstract implements DataProvider
{

    protected $calls = 0;
    protected $data = [];

    public function get(PaginationDataContract $paginationData): Collection
    {
        $this->calls++;
        $paginationData->setItemCount(count($this->data));
        $paginationData->setTotalItems(count($this->data));
        return new Collection($this->data);
    }

    public function getCalls(): int
    {
        return $this->calls;
    }

    public function getFilters(): FilterCollection
    {
        return $this->filters;
    }

    public function getQuery(): Query
    {
        return $this->query;
    }
    public function getSorts(): SortCollection
    {
        return $this->sorts;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}
