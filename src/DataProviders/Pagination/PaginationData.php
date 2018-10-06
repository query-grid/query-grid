<?php

namespace Willishq\QueryGrid\DataProviders\Pagination;

use Willishq\QueryGrid\Contracts\PaginationData as PaginationDataContract;

class PaginationData implements PaginationDataContract
{
    /**
     * @var int
     */
    private $totalItems;
    /**
     * @var int
     */
    private $itemCount;
    /**
     * @var int
     */
    private $currentPage;
    /**
     * @var int
     */
    private $perPage;

    public function __construct($perPage = 25, $currentPage = 1)
    {
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    public function setTotalItems(int $totalItems)
    {
        $this->totalItems = $totalItems;
    }

    public function setItemCount(int $itemCount)
    {
        $this->itemCount = $itemCount;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getTotalItems(): ?int
    {
        return $this->totalItems;
    }

    public function getItemCount(): ?int
    {
        return $this->itemCount;
    }

    public function toArray(): array
    {
        $response = [
            'currentPage' => $this->getCurrentPage(),
            'perPage' => $this->getPerPage(),
        ];

        if (!is_null($this->itemCount)) {
            $response['items'] = $this->getItemCount();
        }

        if (!is_null($this->totalItems)) {
            $response['totalItems'] = $this->getTotalItems();
            $response['lastPage'] = (int)ceil($this->getTotalItems() / $this->getPerPage());
        }

        return $response;
    }
}
