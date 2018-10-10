<?php

namespace Tests\Columns;

use Tests\TestCase;
use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Columns\Filter;

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
        $this->assertEquals('k', $filterContains->getField());
        $this->assertEquals('k', $filterStarts->getField());

        $column->fromField('other');

        $this->assertEquals('other', $filterContains->getField());
        $this->assertEquals('other', $filterStarts->getField());
    }

    /**
     * @test
     * @expectedException \Willishq\QueryGrid\Columns\ColumnException
     * @expectedExceptionMessage You can only add one of each filter type to a column.
     */
    public function itRejectsDuplicateFilterTypes()
    {
        $column = new Column('k', 'l');
        $column->addFilter(Filter::CONTAINS, 'Contains String');
        $column->addFilter(Filter::CONTAINS, 'Whoops');
    }

    /** @test */
    public function itSetsSortable()
    {
        $column = new Column('k', 'l');

        $this->assertFalse($column->isSortable());

        $column->sortable();

        $this->assertTrue($column->isSortable());
    }

    /** @test */
    public function itSetsQueryable()
    {
        $column = new Column('k', 'l');

        $this->assertFalse($column->isQueryable());

        $column->queryable();

        $this->assertTrue($column->isQueryable());
    }

    /** @test */
    public function itDetectsFilterable()
    {
        $column = new Column('k', 'l');

        $this->assertFalse($column->isFilterable());

        $column->addFilter(Filter::CONTAINS, 'Contains String');

        $this->assertTrue($column->isFilterable());
    }

    /** @test */
    public function itReturnsAnArray()
    {
        $column = new Column('k', 'l');

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'sortable' => false,
            'queryable' => false,
            'filterable' => false,
        ], $column->toArray());

        $column = new Column('k', 'l');
        $column->sortable();

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'sortable' => true,
            'queryable' => false,
            'filterable' => false,
        ], $column->toArray());

        $column = new Column('k', 'l');
        $column->queryable();

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'sortable' => false,
            'queryable' => true,
            'filterable' => false,
        ], $column->toArray());

        $column = new Column('k', 'l');
        $filterContains = $column->addFilter(Filter::CONTAINS, 'Contains String');

        $this->assertEquals([
            'key' => 'k',
            'label' => 'l',
            'sortable' => false,
            'queryable' => false,
            'filterable' => true,
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
            'sortable' => false,
            'queryable' => false,
            'filterable' => true,
            'filters' => [
                'k.' . Filter::CONTAINS => $filterContains->toArray(),
                'k.' . Filter::STARTS_WITH => $filterStarts->toArray(),
            ],
        ], $column->toArray());
    }
}
