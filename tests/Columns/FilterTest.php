<?php

namespace Tests\Columns;

use Tests\TestCase;
use QueryGrid\QueryGrid\Columns\Filter;

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
     * @expectedException \QueryGrid\QueryGrid\Columns\FilterException
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
            ],
        ], $filter->getOptions());
    }

    /** @test */
    public function itSetsAFilterName()
    {
        $filter = new Filter(Filter::CONTAINS);
        $filter->setName('Awesome Filter');

        $this->assertEquals('Awesome Filter', $filter->getName());
    }

    /** @test */
    public function itSetsAFilterField()
    {
        $filter = new Filter(Filter::CONTAINS);
        $filter->setField('field');

        $this->assertEquals('field', $filter->getField());
    }

    /** @test */
    public function itReturnsAnArray()
    {
        $filter = new Filter(Filter::CONTAINS);

        $this->assertEquals([
            'type' => Filter::CONTAINS,
            'name' => '',
        ], $filter->toArray());

        $filter = new Filter(Filter::CONTAINS);
        $filter->setName('Filter Name');
        $this->assertEquals([
            'type' => Filter::CONTAINS,
            'name' => 'Filter Name',
        ], $filter->toArray());


        $filter = new Filter(Filter::MATCH_ONE_OPTION);
        $filter->addOption('option-1', 'Option 1');
        $filter->addOption('option-2', 'Option 2');
        $this->assertEquals([
            'type' => Filter::MATCH_ONE_OPTION,
            'name' => '',
            'options' => [
                [
                    'value' => 'option-1',
                    'label' => 'Option 1',
                ],
                [
                    'value' => 'option-2',
                    'label' => 'Option 2',
                ],
            ],
        ], $filter->toArray());
    }
}
