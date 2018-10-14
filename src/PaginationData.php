<?php

namespace QueryGrid\QueryGrid;

use QueryGrid\QueryGrid\Contracts\Arrayable;

class PaginationData implements Arrayable
{
    /** @var int */
    private $perPage;
    /** @var int */
    private $itemCount = 0;
    private $totalItems;
    private $currentPage = 1;

    public function __construct(int $perPage)
    {
        $this->perPage = $perPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getItemCount(): int
    {
        if (is_null($this->totalItems)) {
            return $this->itemCount;
        }
        return $this->getLastPage() === $this->getCurrentPage()
            ? $this->getTotalItems() % $this->getPerPage()
            : $this->getPerPage();
    }

    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getLastPage(): ?int
    {
        if (is_null($this->totalItems)) {
            return null;
        }
        return intval(ceil($this->totalItems / $this->perPage), 10);
    }

    public function setItemCount(int $itemCount)
    {
        $this->itemCount = $itemCount;
    }

    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;
    }

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
