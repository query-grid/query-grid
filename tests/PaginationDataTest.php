<?php

namespace Tests;

use Willishq\QueryGrid\Contracts\Arrayable;
use Willishq\QueryGrid\PaginationData;

class PaginationDataTest extends TestCase
{
    /** @test */
    public function itIsCreatable()
    {
        $paginationData = new PaginationData(25);

        $this->assertEquals(25, $paginationData->getPerPage());
        $this->assertEquals(0, $paginationData->getItemCount());
        $this->assertEquals(1, $paginationData->getCurrentPage());
        $this->assertEquals(null, $paginationData->getTotalItems());
        $this->assertEquals(null, $paginationData->getLastPage());
    }

    /** @test */
    public function itSetsItemCount()
    {
        $paginationData = new PaginationData(25);
        $paginationData->setItemCount(10);

        $this->assertEquals(25, $paginationData->getPerPage());
        $this->assertEquals(10, $paginationData->getItemCount());
        $this->assertEquals(1, $paginationData->getCurrentPage());
        $this->assertEquals(null, $paginationData->getTotalItems());
        $this->assertEquals(null, $paginationData->getLastPage());
    }


    /** @test */
    public function itSetsTotalItems()
    {
        $paginationData = new PaginationData(10);
        $paginationData->setTotalItems(100);

        $this->assertEquals(10, $paginationData->getPerPage());
        $this->assertEquals(10, $paginationData->getItemCount());
        $this->assertEquals(1, $paginationData->getCurrentPage());
        $this->assertEquals(100, $paginationData->getTotalItems());
        $this->assertEquals(10, $paginationData->getLastPage());
    }


    /** @test */
    public function itGetsCorrectItemCountForCurrentPage()
    {
        $paginationData = new PaginationData(10);
        $paginationData->setTotalItems(64);
        $paginationData->setCurrentPage(7);

        $this->assertEquals(10, $paginationData->getPerPage());
        $this->assertEquals(4, $paginationData->getItemCount());
        $this->assertEquals(7, $paginationData->getCurrentPage());
        $this->assertEquals(64, $paginationData->getTotalItems());
        $this->assertEquals(7, $paginationData->getLastPage());
    }

    /** @test */
    public function itIsArrayable()
    {
        $paginationData = new PaginationData(10);
        $paginationData->setTotalItems(64);
        $paginationData->setCurrentPage(7);

        $this->assertInstanceOf(Arrayable::class, $paginationData);
        $this->assertEquals([
            'perPage' => 10,
            'itemCount' => 4,
            'currentPage' => 7,
            'totalItems' => 64,
            'lastPage' => 7,
        ], $paginationData->toArray());
    }
}
