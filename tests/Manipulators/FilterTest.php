<?php

namespace Willishq\QueryGridTests\Manipulators;

use Willishq\QueryGrid\Manipulators\Filter;
use Willishq\QueryGridTests\TestCase;

class FilterTest extends TestCase
{
    /** @test */
    public function itCanGetFilterFields()
    {
        $filter = new Filter('field', 'value');

        $this->assertEquals('field', $filter->getField());
        $this->assertEquals('value', $filter->getValue());
    }

    /** @test */
    public function isCanMakeWildcardPrefixedFilters()
    {
        $filter = new Filter('field', '*|value');

        $this->assertEquals('field', $filter->getField());
        $this->assertEquals('value', $filter->getValue());
        $this->assertTrue($filter->hasWildcardPrefix());
    }

    /** @test */
    public function isCanMakeWildcardSuffixedFilters()
    {
        $filter = new Filter('field', 'value|*');

        $this->assertEquals('field', $filter->getField());
        $this->assertEquals('value', $filter->getValue());
        $this->assertTrue($filter->hasWildcardSuffix());
    }

    /** @test */
    public function itCanDetectGreaterThanFilters()
    {
        $filter = new Filter('number', '>|5');

        $this->assertTrue($filter->hasGreaterThan());
        $this->assertFalse($filter->hasLessThan());
        $this->assertFalse($filter->hasGreaterOrEqual());
        $this->assertFalse($filter->hasLessOrEqual());
    }

    /** @test */
    public function itCanDetectLessThanFilters()
    {
        $filter = new Filter('number', '<|5');

        $this->assertTrue($filter->hasLessThan());
        $this->assertFalse($filter->hasGreaterThan());
        $this->assertFalse($filter->hasGreaterOrEqual());
        $this->assertFalse($filter->hasLessOrEqual());
    }

    /** @test */
    public function itCanDetectGreaterOrEqualFilters()
    {
        $filter = new Filter('number', '>:|5');

        $this->assertTrue($filter->hasGreaterOrEqual());
        $this->assertFalse($filter->hasLessThan());
        $this->assertFalse($filter->hasGreaterThan());
        $this->assertFalse($filter->hasLessOrEqual());
    }

    /** @test */
    public function itCanDetectLessOrEqualFilters()
    {
        $filter = new Filter('number', '<:|5');

        $this->assertTrue($filter->hasLessOrEqual());
        $this->assertFalse($filter->hasGreaterOrEqual());
        $this->assertFalse($filter->hasLessThan());
        $this->assertFalse($filter->hasGreaterThan());
    }
}
