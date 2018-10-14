<?php

namespace Tests\Columns;

use Tests\TestCase;
use QueryGrid\QueryGrid\Collections\CollectionAbstract;
use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;
use QueryGrid\QueryGrid\Columns\Filter;

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

    /** @test */
    public function itGetsAllFilters()
    {
        $columnCollection = new ColumnCollection();

        $columnName = new Column('name', 'Name');
        $filterNameContains = $columnName->addFilter(Filter::CONTAINS);

        $columnBirthday = new Column('birthday', 'Date of Birth');
        $columnBirthday->fromField('dob');
        $filterBirthdayGreaterThan = $columnBirthday->addFilter(Filter::GREATER_THAN);
        $filterBirthdayLessThan = $columnBirthday->addFilter(Filter::LESS_THAN);

        $columnCollection->add($columnName);
        $columnCollection->add($columnBirthday);

        $this->assertEquals([
            'name.' . Filter::CONTAINS => $filterNameContains,
            'birthday.' . Filter::GREATER_THAN => $filterBirthdayGreaterThan,
            'birthday.' . Filter::LESS_THAN => $filterBirthdayLessThan
        ], $columnCollection->getAllFilters());
    }

    /** @test */
    public function itGetsAllQueryableFields()
    {
        $columnCollection = new ColumnCollection();

        $columnName = new Column('name', 'Name');
        $columnName->queryable();
        $columnBirthday = new Column('birthday', 'Date of Birth');
        $columnAbout = new Column('about', 'about');
        $columnAbout->queryable();

        $columnCollection->add($columnName);
        $columnCollection->add($columnBirthday);
        $columnCollection->add($columnAbout);

        $this->assertEquals([
            $columnName,
            $columnAbout,
        ], $columnCollection->getQueryableColumns()->all());
    }

    /** @test */
    public function itGetsAllSortableFields()
    {
        $columnCollection = new ColumnCollection();

        $columnName = new Column('name', 'Name');
        $columnName->sortable();
        $columnBirthday = new Column('birthday', 'Date of Birth');
        $columnBirthday->sortable();
        $columnAbout = new Column('about', 'about');
        $columnCollection->add($columnName);
        $columnCollection->add($columnBirthday);
        $columnCollection->add($columnAbout);

        $this->assertEquals([
            $columnName,
            $columnBirthday,
        ], $columnCollection->getSortableColumns()->all());
    }
}
