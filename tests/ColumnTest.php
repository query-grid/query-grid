<?php

namespace Willishq\QueryGridTests;

use Willishq\QueryGrid\Column;

class ColumnTest extends TestCase
{
    /** @test */
    public function itCanCreateAColumn()
    {
        $column = new Column('column', 'Column Label');
        $this->assertEquals('column', $column->getKey());
        $this->assertEquals('Column Label', $column->getLabel());
    }

    /** @test */
    public function itCanMarkAColumnAsFilterable()
    {
        $column = new Column('column', 'Column Label');

        $this->assertFalse($column->isFilterable());
        $response = $column->filterable();

        $this->assertEquals($column, $response);
        $this->assertTrue($column->isFilterable());
    }

    /** @test */
    public function itCanMarkAColumnAsQueryable()
    {
        $column = new Column('column', 'Column Label');

        $this->assertFalse($column->isQueryable());
        $response = $column->queryable();

        $this->assertEquals($column, $response);
        $this->assertTrue($column->isQueryable());
    }

    /** @test */
    public function itCanMarkAColumnAsSortable()
    {
        $column = new Column('column', 'Column Label');

        $this->assertFalse($column->isSortable());
        $response = $column->sortable();

        $this->assertEquals($column, $response);
        $this->assertTrue($column->isSortable());
    }
    /** @test */
    public function itCanFormatAGivenValue()
    {
        $column = new Column('column', 'Column Label');

        $column->formatter(function ($value) {
            return '_' . $value;
        });

        $this->assertEquals('_hello', $column->format('hello'));
    }
    /** @test */
    public function itCanReturnAValueIfThereIsNoFormatter()
    {
        $column = new Column('column', 'Column Label');

        $this->assertEquals('hello', $column->format('hello'));
    }
}
