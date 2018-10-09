<?php

namespace Tests\Columns;

use Tests\TestCase;
use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Filter;

class ColumnTest extends TestCase
{
    /** @test */
    public function itIsCreatable()
    {
        $column = new Column('key', 'label');

        $this->assertEquals('key', $column->getKey());
        $this->assertEquals('key', $column->getField());
        $this->assertEquals('label', $column->getLabel());
    }

    /** @test */
    public function itChangesTheFromField()
    {
        $column = new Column('key', 'label');
        $response = $column->fromField('field');

        $this->assertEquals('key', $column->getKey());
        $this->assertEquals('field', $column->getField());
        $this->assertEquals('label', $column->getLabel());
        $this->assertSame($response, $column);
    }

    /** @test */
    public function itFormatsValues()
    {
        $column = new Column('key', 'label');
        $response = $column->withFormat(function ($value) {
            return 'all_' . $value;
        });
        $this->assertTrue($column->hasFormat());
        $this->assertEquals('all_of', $column->format('of'));
        $this->assertSame($response, $column);
    }

    /** @test */
    public function itAddsAFilter()
    {
        $column = new Column('k', 'l');
        $filter = $column->addFilter(Filter::CONTAINS, 'Contains String');
        $filters = $column->getFilters();

        $this->assertArrayHasKey('k.' . Filter::CONTAINS, $filters);
        $this->assertEquals($filter, $filters['k.' . Filter::CONTAINS]);
    }

    /** @test */
    public function itAddsManyFilters()
    {
        $column = new Column('k', 'l');
        $filterContains = $column->addFilter(Filter::CONTAINS, 'Contains String');
        $filterStarts = $column->addFilter(Filter::STARTS_WITH, 'Starts with');
        $filters = $column->getFilters();

        $this->assertArrayHasKey('k.' . Filter::CONTAINS, $filters);
        $this->assertArrayHasKey('k.' . Filter::STARTS_WITH, $filters);
        $this->assertEquals($filterContains, $filters['k.' . Filter::CONTAINS]);
        $this->assertEquals($filterStarts, $filters['k.' . Filter::STARTS_WITH]);
    }

    /**
     * @test
     * @expectedException \Willishq\QueryGrid\Columns\ColumnException
     * @expectedExceptionMessage You can not add more than one filter of each type to a column.
     */
    public function itRejectsDuplicateFilterTypes()
    {
        $column = new Column('k', 'l');
        $column->addFilter(Filter::CONTAINS, 'Contains String');
        $column->addFilter(Filter::CONTAINS, 'Whoops');
    }

    /** @test */
    public function itReturnsAnArray()
    {
        $column = new Column('k', 'l');

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
        ], $column->toArray());

        $column = new Column('k', 'l');
        $filterContains = $column->addFilter(Filter::CONTAINS, 'Contains String');

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'filters' => [
                'k.' . Filter::CONTAINS => $filterContains->toArray(),
            ],
        ], $column->toArray());

        $column = new Column('k', 'l');
        $filterContains = $column->addFilter(Filter::CONTAINS, 'Contains String');
        $filterStarts = $column->addFilter(Filter::STARTS_WITH, 'Starts with String');

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'filters' => [
                'k.' . Filter::CONTAINS => $filterContains->toArray(),
                'k.' . Filter::STARTS_WITH => $filterStarts->toArray(),
            ],
        ], $column->toArray());
    }
}
