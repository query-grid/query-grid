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
}
