<?php

namespace Tests;

use Willishq\QueryGrid\Query;

class QueryTest extends TestCase
{
    /** @test */
    public function itIsCreatable()
    {
        $query = new Query('and', ['about', 'username']);

        $this->assertEquals('and', $query->getQuery());
        $this->assertEquals(['about', 'username'], $query->getFields());
    }

    /** @test */
    public function itConvertsToAnArray()
    {
        $query = new Query('and', ['about', 'username']);

        $this->assertEquals([
            'query' => 'and',
            'fields' => ['about', 'username',],
        ], $query->toArray());
    }
}
