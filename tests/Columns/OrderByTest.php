<?php

namespace Tests\Columns;

use Tests\TestCase;
use Willishq\QueryGrid\Columns\OrderBy;

class OrderByTest extends TestCase
{
    /** @test */
    public function itCanParseOrderByString()
    {
        $orderBy = new OrderBy('name');

        $this->assertEquals('name', $orderBy->getField());
        $this->assertFalse($orderBy->isDescending());
    }

    /** @test */
    public function itCanCreateADescendingOrderBy()
    {
        $orderBy = new OrderBy('name');
        $orderBy->setDescending(true);

        $this->assertEquals('name', $orderBy->getField());
        $this->assertTrue($orderBy->isDescending());
    }
}
