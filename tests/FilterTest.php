<?php

namespace Tests;

use Willishq\QueryGrid\Filter;

class FilterTest extends TestCase
{
    /** @test */
    public function itGetsFilterTypes()
    {
        $types = Filter::getTypes();

        $this->assertEquals([
            'st',
            'enw',
            'con',
            'exa',
            'lt',
            'lte',
            'gt',
            'gte',
            'm1',
            'mn',
        ], $types);
    }

    /** @test */
    public function itCanBeCreated()
    {
        $filter = new Filter(Filter::STARTS_WITH);

        $this->assertEquals(Filter::STARTS_WITH, $filter->getType());
    }

    /**
     * @test
     * @expectedException \Willishq\QueryGrid\FilterException
     * @expectedExceptionMessage Trying to set an unknown filter type: invalidFilter
     */
    public function itMustHaveAnExistingFilter()
    {
         new Filter('invalidFilter');

    }

    /** @test */
    public function itAddsAnOption()
    {
        $filter = new Filter(Filter::MATCH_ONE_OPTION);
        $filter->addOption('option', 'Option');

        $this->assertEquals([
            [
                'value' => 'option',
                'label' => 'Option',
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
                'value' => 'option-1',
                'label' => 'Option 1',
            ],
            [
                'value' => 'option-2',
                'label' => 'Option 2',
            ]
        ], $filter->getOptions());
    }

    /** @test */
    public function itSetsAFilterName()
    {
        $filter = new Filter(Filter::CONTAINS);
        $filter->setName('Awesome Filter');

        $this->assertEquals('Awesome Filter', $filter->getName());
    }
}
