<?php

namespace Willishq\QueryGrid\Contracts;

interface PaginationData
{
    public function __construct($perPage = 25, $currentPage = 1);

    public function setTotalItems(int $totalItems);

    public function setItemCount(int $itemCount);

    public function getPerPage(): int;

    public function getCurrentPage(): int;

    public function getTotalItems(): ?int;

    public function getItemCount(): ?int;

    public function toArray(): array;
}
