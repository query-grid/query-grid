<?php

namespace Tests;

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
    }    /** @test */
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
}
