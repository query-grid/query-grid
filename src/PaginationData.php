<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Contracts\Arrayable;

class PaginationData implements Arrayable
{
    /** @var int */
    private $perPage;
    /** @var int */
    private $itemCount = 0;
    /** @var int|null */
    private $totalItems;
    /** @var int */
    private $currentPage = 1;

    /**
     * PaginationData constructor.
     * @param int $perPage
     */
    public function __construct(int $perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getItemCount(): int
    {
        $totalItems = $this->getTotalItems();
        if (is_null($totalItems)) {
            return $this->itemCount;
        }
        return $this->getLastPage() === $this->getCurrentPage()
            ? $totalItems % $this->getPerPage()
            : $this->getPerPage();
    }

    /**
     * @return int|null
     */
    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int|null
     */
    public function getLastPage(): ?int
    {
        if (is_null($this->totalItems)) {
            return null;
        }
        return intval(ceil($this->totalItems / $this->perPage), 10);
    }

    /**
     * @param int $itemCount
     * @return void
     */
    public function setItemCount(int $itemCount)
    {
        $this->itemCount = $itemCount;
    }

    /**
     * @param int $totalItems
     * @return void
     */
    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    /**
     * @param int $currentPage
     * @return void
     */
    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'perPage' => $this->getPerPage(),
            'itemCount' =>$this->getItemCount(),
            'currentPage' =>$this->getCurrentPage(),
            'totalItems' => $this->getTotalItems(),
            'lastPage' =>$this->getLastPage(),
        ];
    }
}
