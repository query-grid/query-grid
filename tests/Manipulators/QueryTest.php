<?php

namespace Willishq\QueryGridTests\Manipulators;

use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGridTests\TestCase;

class QueryTest extends TestCase
{
    /** @test */
    public function itCanGetQueryFields()
    {
        $query = new Query('value');

        $this->assertEquals('value', $query->getValue());
    }

    /** @test */
    public function itCanMakeAWildcardPrefixedQuery()
    {
        $query = new Query('*|value');

        $this->assertEquals('value', $query->getValue());
        $this->assertTrue($query->hasWildcardPrefix());
    }

    /** @test */
    public function itCanMakeAWildcardSuffixedQuery()
    {
        $query = new Query('value|*');

        $this->assertEquals('value', $query->getValue());
        $this->assertTrue($query->hasWildcardSuffix());
    }
}
