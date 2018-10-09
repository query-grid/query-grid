<?php

namespace Tests\Columns;

use Tests\TestCase;
use Willishq\QueryGrid\Collections\CollectionAbstract;
use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Columns\ColumnCollection;

class ColumnCollectionTest extends TestCase
{
    /** @test */
    public function itExtendsTheAbstractCollection()
    {
        $columnCollection = new ColumnCollection();
        $this->assertInstanceOf(CollectionAbstract::class, $columnCollection);
    }

    /** @test */
    public function itAddsAColumn()
    {
        $columnCollection = new ColumnCollection();
        $column = new Column('k', 'l');
        $columnCollection->add($column);

        $this->assertCount(1, $columnCollection);
        $this->assertSame($column, $columnCollection->first());
        $this->assertSame($column, $columnCollection->last());
    }

    /** @test */
    public function itAddsManyColumns()
    {
        $columnCollection = new ColumnCollection();
        $columnFirst = new Column('first', 'First');
        $columnCollection->add($columnFirst);
        $columnCollection->add(new Column('second', 'Second'));
        $columnLast = new Column('last', 'Last');

        $columnCollection->add($columnLast);

        $this->assertCount(3, $columnCollection);
        $this->assertSame($columnFirst, $columnCollection->first());
        $this->assertSame($columnLast, $columnCollection->last());
    }

    /**
     * @test
     * @expectedException \TypeError
     */
    public function itDoesNotAddNonColumns()
    {
        $columnCollection = new ColumnCollection();
        $columnCollection->add(1);
    }

    /** @test */
    public function itConvertsToAnArray()
    {
        $columnCollection = new ColumnCollection();
        $columnCollection->add(new Column('first', 'First'));
        $columnCollection->add(new Column('second', 'Second'));

        $this->assertEquals([
            [
                'key' => 'first',
                'label' => 'First',
                'sortable' => false,
                'queryable' => false,
                'filterable' => false,
            ],
            [
                'key' => 'second',
                'label' => 'Second',
                'sortable' => false,
                'queryable' => false,
                'filterable' => false,
            ],
        ], $columnCollection->toArray());
    }
}
