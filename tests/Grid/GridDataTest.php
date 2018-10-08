<?php

namespace Tests\Grid;

use Willishq\QueryGrid\GridResult;

class GridDataTest extends TestCase
{
    /** @test */
    public function itCanCreateAnInstance()
    {
        $grid = $this->itHasAGridInstance();

        $this->assertSame($this->dataProvider, $grid->getDataProvider());
        $this->assertEmpty($grid->getQueryParams());
    }

    /** @test */
    public function itCanSetTheResource()
    {
        $grid = $this->itHasAGridInstance();

        $grid->setResource('resource');

        $this->assertEquals('resource', $this->dataProvider->getResource());
    }

    /** @test */
    public function itReturnsAGridResponse()
    {
        $grid = $this->itHasAGridInstance();

        $response = $grid->getResult();

        $this->assertInstanceOf(GridResult::class, $response);
    }
}
