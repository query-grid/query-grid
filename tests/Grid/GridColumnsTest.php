<?php

namespace Tests\Grid;

use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;

class GridColumnsTest extends TestCase
{
    /** @test */
    public function itAddsAColumn()
    {
        $grid = $this->itHasAGridInstance();

        $column = $grid->addColumn('key', 'label');

        $this->assertInstanceOf(Column::class, $column);
        $this->assertInstanceOf(ColumnCollection::class, $grid->getColumns());
        $this->assertCount(1, $grid->getColumns());
        $this->assertSame($column, $grid->getColumns()->first());
        $this->assertSame($column, $grid->getColumns()->last());
    }

    /** @test */
    public function itAddsManyColumns()
    {
        $grid = $this->itHasAGridInstance();

        $firstColumn = $grid->addColumn('first', 'First');
        $grid->addColumn('middle', 'Middle');
        $lastColumn = $grid->addColumn('last', 'Last');
        $this->assertInstanceOf(ColumnCollection::class, $grid->getColumns());
        $this->assertCount(3, $grid->getColumns());
        $this->assertSame($firstColumn, $grid->getColumns()->first());
        $this->assertSame($lastColumn, $grid->getColumns()->last());
    }
}
