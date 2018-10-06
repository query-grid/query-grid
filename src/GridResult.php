<?php

namespace Willishq\QueryGrid;

use Willishq\QueryGrid\Contracts\PaginationData;

class GridResult
{
    /**
     * @var PaginationData
     */
    private $paginationData;
    /**
     * @var array
     */
    private $items;
    /**
     * @var ColumnCollection
     */
    private $columns;

    public function __construct(PaginationData $paginationData, array $items, ColumnCollection $columns)
    {
        $this->paginationData = $paginationData;
        $this->items = $items;
        $this->columns = $columns;
    }

    public function toArray()
    {
        return [
            'columns' => $this->columns->toArray(),
            'pagination' => $this->pagination()->toArray(),
            'items' => $this->items(),
        ];
    }

    public function items(): array
    {
        return $this->items;
    }

    public function pagination(): PaginationData
    {
        return $this->paginationData;
    }
}
