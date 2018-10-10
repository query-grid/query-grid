<?php

namespace Tests\Columns\Formatters;

use Tests\TestCase;
use Willishq\QueryGrid\Columns\Formatters\Date;

class DateTest extends TestCase
{
    /** @test */
    public function itIsCreatable()
    {
        $date = new Date('Y-m-d', 'd/m/Y');

        $this->assertEquals('12/12/2019', $date('2019-12-12'));
    }
    /** @test */
    public function itReturnsEmptyStringForNonDate()
    {
        $date = new Date('Y-m-d', 'd/m/Y');
        $this->assertEquals('', $date('231ev'));
    }
}
