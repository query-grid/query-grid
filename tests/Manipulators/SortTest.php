<?php

namespace Willishq\QueryGridTests\Manipulators;

use Willishq\QueryGridTests\TestCase;
use Willishq\QueryGrid\Manipulators\Sort;

class SortTest extends TestCase
{
    /** @test */
    public function itCanCreateAnAscendingSortEntity()
    {
        $sort = new Sort('field');
        $this->assertFalse($sort->descending());
        $this->assertEquals('field', $sort->field());
    }
    /** @test */
    public function itCanCreateADescendingSortEntity()
    {
        $sort = new Sort('-field');
        $this->assertTrue($sort->descending());
        $this->assertEquals('field', $sort->field());
    }
}
