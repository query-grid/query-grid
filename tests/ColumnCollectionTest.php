<?php

namespace Willishq\QueryGridTests;

use Willishq\QueryGrid\Column;
use Willishq\QueryGrid\ColumnCollection;

class ColumnCollectionTest extends TestCase
{
    /** @test */
    public function itCanAddAColumn()
    {
        $collection = new ColumnCollection();
        $column = new Column('key', 'Key');
        $collection->add($column);

        $this->assertCount(1, $collection);
        $this->assertSame($column, $collection->get(0));
    }

    /** @test */
    public function itCanAddMultipleColumns()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);
        $this->assertCount(2, $collection);
        $this->assertSame($columnKey, $collection->get(0));
        $this->assertSame($columnId, $collection->get(1));
    }

    /** @test */
    public function itCanGetFilterableKeys()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->filterable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertEquals(['key'], $collection->filterableKeys);
    }

    /** @test */
    public function itCanGetQueryableKeys()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->queryable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertEquals(['key'], $collection->queryableKeys);
    }

    /** @test */
    public function itCanGetSortableKeys()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->sortable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertEquals(['key'], $collection->sortableKeys);
    }

    /** @test */
    public function itCanTellIfAColumnIsFilterable()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->filterable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertTrue($collection->isFilterableKey('key'));
        $this->assertTrue($collection->hasFilters());
        $this->assertFalse($collection->isFilterableKey('id'));
    }

    /** @test */
    public function itCanTellIfAColumnIsQueryable()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->queryable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertTrue($collection->isQueryableKey('key'));
        $this->assertTrue($collection->hasQuery());
        $this->assertFalse($collection->isQueryableKey('id'));
    }

    /** @test */
    public function itCanTellIfAColumnIsSortable()
    {
        $collection = new ColumnCollection();
        $columnKey = new Column('key', 'Key');
        $columnKey->sortable();

        $columnId = new Column('id', 'Id');

        $collection->add($columnKey);
        $collection->add($columnId);

        $this->assertTrue($collection->isSortableKey('key'));
        $this->assertTrue($collection->hasSorts());
        $this->assertFalse($collection->isSortableKey('id'));
    }

    /** @test */
    public function itReturnsNullWhenTryingToGetAnUnknownProperty()
    {
        $collection = new ColumnCollection();
        $this->assertNull($collection->unknownProperty);
    }
}
