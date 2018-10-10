<?php

namespace Willishq\QueryGrid;

class PaginationData
{
    /** @var int */
    private $perPage;
    /** @var int */
    private $itemCount = 0;

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
        return $this->itemCount;
    }
    public function getTotalItems(): ?int
    {
        return null;
    }
    public function getCurrentPage(): int
    {
        return 1;
    }
    public function getLastPage(): ?int
    {
        return null;
    }

    public function setItemCount(int $itemCount)
    {
        $this->itemCount = $itemCount;
    }
}
