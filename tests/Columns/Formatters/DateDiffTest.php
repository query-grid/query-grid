<?php

namespace Tests\Columns\Formatters;

use Tests\TestCase;
use QueryGrid\QueryGrid\Columns\Formatters\DateDiff;

class DateDiffTest extends TestCase
{
    /** @test */
    public function itIsCreatable()
    {
        $dateDiff = new DateDiff('Y-m-d', '%y');
        $this->assertEquals(5, $dateDiff->withFromDate('2000-01-01')('2005-01-01'));
    }
    /** @test */
    public function itReturnsEmptyStringForInvalidDates()
    {
        $dateDiff = new DateDiff('Y-m-d', '%y');
        $this->assertEquals('', $dateDiff->withFromDate('342')('2005-01-01'));
        $this->assertEquals('', $dateDiff->withFromDate('2000-01-01')('fnbr'));
    }
}
