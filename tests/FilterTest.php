<?php

namespace Tests;

use Willishq\QueryGrid\Filter;

class FilterTest extends TestCase
{
    /** @test */
    public function itGetsFilterTypes()
    {
        $types = Filter::getTypes();

        $this->assertEquals([0, 1, 2, 3, 4, 5, 6, 7, 8, 9], $types);
    }

    /** @test */
    public function itCanBeCreated()
    {
        $filter = new Filter(Filter::STARTS_WITH);

        $this->assertEquals(Filter::STARTS_WITH, $filter->getType());
    }

    /** @test */
    public function itAddsAnOption()
    {
        $filter = new Filter(Filter::MATCH_ONE_OPTION);
        $filter->addOption('option', 'Option');

        $this->assertEquals([
            [
                'key' => 'option',
                'value' => 'Option',
            ],
        ], $filter->getOptions());
    }

    /** @test */
    public function itAddsManyOptions()
    {
        $filter = new Filter(Filter::MATCH_ONE_OPTION);
        $filter->addOption('option-1', 'Option 1');
        $filter->addOption('option-2', 'Option 2');

        $this->assertEquals([
            [
                'key' => 'option-1',
                'value' => 'Option 1',
            ],
            [
                'key' => 'option-2',
                'value' => 'Option 2',
            ]
        ], $filter->getOptions());
    }
}
