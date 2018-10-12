<?php

namespace Tests\Grid;

use Willishq\QueryGrid\Columns\Filter;

class GridQueryTest extends TestCase
{
    /** @test */
    public function itParsesFilters()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')
            ->addFilter(Filter::CONTAINS);
        $column = $grid->addColumn('birthday', 'Date of Birth')
            ->fromField('dob');
        $column->addFilter(Filter::GREATER_THAN);
        $column->addFilter(Filter::LESS_THAN);

        $grid->getResult([
            'filters' => [
                'name.con' => 'ndr',
                'birthday.gt' => '1980-01-01',
                'birthday.lt' => '2000-01-01',
            ],
        ]);

        $this->assertEquals([
            'name' => [
                [
                    'type' => Filter::CONTAINS,
                    'value' => 'ndr',
                ],
            ],
            'dob' => [
                [
                    'type' => Filter::GREATER_THAN,
                    'value' => '1980-01-01',
                ],
                [
                    'type' => Filter::LESS_THAN,
                    'value' => '2000-01-01',
                ]
            ],
        ], $this->dataProvider->getFilters());
    }

    /** @test */
    public function itIgnoresInvalidFilters()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')
            ->addFilter(Filter::CONTAINS);
        $column = $grid->addColumn('birthday', 'Date of Birth')
            ->fromField('dob');
        $column->addFilter(Filter::GREATER_THAN);
        $column->addFilter(Filter::LESS_THAN);

        $grid->getResult([
            'filters' => [
                'name.con' => 'ndr',
                'birthday.gt' => '1980-01-01',
                'birthday.lt' => '2000-01-01',
                'orange' => 'red',
            ],
        ]);

        $this->assertEquals([
            'name' => [
                [
                    'type' => Filter::CONTAINS,
                    'value' => 'ndr',
                ],
            ],
            'dob' => [
                [
                    'type' => Filter::GREATER_THAN,
                    'value' => '1980-01-01',
                ],
                [
                    'type' => Filter::LESS_THAN,
                    'value' => '2000-01-01',
                ]
            ],
        ], $this->dataProvider->getFilters());
    }

    /** @test */
    public function iSetsAQuery()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')->queryable();
        $grid->addColumn('birthday', 'Date of Birth');
        $grid->addColumn('about', 'about')->queryable();


        $grid->getResult([
            'query' => 'and',
        ]);

        $query = $this->dataProvider->getQuery();

        $this->assertEquals('and', $query->getQuery());
        $this->assertEquals(['name', 'about'], $query->getFields());
    }

    /** @test */
    public function itAddsSortingAscending()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')->sortable();
        $grid->addColumn('birthday', 'Date of Birth');


        $grid->getResult([
            'sort' => 'name',
        ]);

        $orderBy = $this->dataProvider->getOrderBy();

        $this->assertCount(1, $orderBy);
        $this->assertFalse($orderBy[0]->isDescending());
        $this->assertEquals('name', $orderBy[0]->getField());
    }

    /** @test */
    public function itAddsSortingDescending()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')->sortable();
        $grid->addColumn('birthday', 'Date of Birth');


        $grid->getResult([
            'sort' => '-name',
        ]);

        $orderBy = $this->dataProvider->getOrderBy();

        $this->assertCount(1, $orderBy);
        $this->assertTrue($orderBy[0]->isDescending());
        $this->assertEquals('name', $orderBy[0]->getField());
    }

    /** @test */
    public function itAddsMultipleSorting()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')->sortable();
        $grid->addColumn('birthday', 'Date of Birth')->sortable();


        $grid->getResult([
            'sort' => '-name,birthday',
        ]);

        $orderBy = $this->dataProvider->getOrderBy();
        $this->assertCount(2, $orderBy);
        $this->assertTrue($orderBy[0]->isDescending());
        $this->assertEquals('name', $orderBy[0]->getField());
        $this->assertFalse($orderBy[1]->isDescending());
        $this->assertEquals('birthday', $orderBy[1]->getField());
    }

    /** @test */
    public function itSortsOnFieldNotString()
    {
        $grid = $this->itHasAGridInstance();

        $grid->addColumn('name', 'Name')
            ->fromField('full_name')
            ->sortable();
        $grid->addColumn('birthday', 'Date of Birth')->sortable();


        $grid->getResult([
            'sort' => 'name,birthday',
        ]);

        $orderBy = $this->dataProvider->getOrderBy();
        $this->assertEquals('full_name', $orderBy[0]->getField());
    }

    /** @test */
    public function itSetsAQueryAndSortAndFilter()
    {
        $grid = $this->itHasAGridInstance();
        $columnName = $grid->addColumn('name', 'Name')
            ->fromField('full_name');
        $columnName->sortable();
        $columnName->queryable();
        $columnName->addFilter(Filter::CONTAINS);

        $columnBirthday = $grid->addColumn('birthday', 'Date of Birth');
        $columnBirthday->sortable();
        $columnBirthday->addFilter(Filter::LESS_THAN);
        $columnAbout = $grid->addColumn('about', 'About Me');
        $columnAbout->queryable();

        $grid->getResult([
            'sort' => 'name,-birthday',
            'filters' => [
                'name.con' => 'an',
                'birthday.lt' => '1999-12-31',
            ],
            'query' => 'and',
        ]);

        $filters = $this->dataProvider->getFilters();
        $query = $this->dataProvider->getQuery();
        $orderBy = $this->dataProvider->getOrderBy();
        $this->assertEquals([
            'full_name' => [
                [
                    'type' => Filter::CONTAINS,
                    'value' => 'an',
                ],
            ],
            'birthday' => [
                [
                    'type' => Filter::LESS_THAN,
                    'value' => '1999-12-31',
                ],
            ],
        ], $filters);

        $this->assertEquals('and', $query->getQuery());
        $this->assertEquals(['full_name', 'about'], $query->getFields());

        $this->assertCount(2, $orderBy);
        $this->assertFalse($orderBy[0]->isDescending());
        $this->assertEquals('full_name', $orderBy[0]->getField());
        $this->assertTrue($orderBy[1]->isDescending());
        $this->assertEquals('birthday', $orderBy[1]->getField());
    }
}
