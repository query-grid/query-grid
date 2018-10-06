<?php

namespace Willishq\QueryGridTests;

use Willishq\QueryGrid\Column;
use Willishq\QueryGrid\ColumnCollection;
use Willishq\QueryGrid\Grid;
use Willishq\QueryGrid\GridResult;
use Willishq\QueryGrid\Manipulators\Filter;
use Willishq\QueryGrid\Manipulators\FilterCollection;
use Willishq\QueryGrid\Manipulators\Query;
use Willishq\QueryGrid\Manipulators\SortCollection;
use Willishq\QueryGridTests\Fixtures\NullDataProvider;

class GridTest extends TestCase
{
    /** @var NullDataProvider */
    private $provider;
    /** @var Grid */
    private $grid;

    public function setUp()
    {
        $this->provider = new NullDataProvider();
        $this->grid = new Grid($this->provider);
    }

    /** @test */
    public function itCanCreateAGridFromADataSource()
    {
        $result = $this->grid->getResults();
        $this->assertEquals(1, $this->provider->getCalls());
        $this->assertInstanceOf(GridResult::class, $result);
    }

    /** @test */
    public function itCanAddAColumnToAGrid()
    {
        $this->grid->addColumn('column', 'Label');
        $columns = $this->grid->getColumns();

        $this->assertCount(1, $columns);
        $this->assertInstanceOf(ColumnCollection::class, $columns);
        $this->assertEquals('column', $columns->get(0)->getKey());
        $this->assertEquals('Label', $columns->get(0)->getLabel());
    }

    /** @test */
    public function itCanAddAColumnWithOptionsToAGrid()
    {
        $this->grid->addColumn('column', 'Label', function (Column $column) {
            $column->filterable()->sortable()->queryable();
        });
        $columns = $this->grid->getColumns();

        $this->assertCount(1, $columns);
        $this->assertTrue($columns->get(0)->isFilterable());
        $this->assertTrue($columns->get(0)->isSortable());
        $this->assertTrue($columns->get(0)->isQueryable());
    }

    /** @test */
    public function itCanAddMultipleColumnsToAGrid()
    {
        $this->grid
            ->addColumn('column', 'Label')
            ->addColumn('second', 'The Label');
        $columns = $this->grid->getColumns();

        $this->assertCount(2, $columns);
        $this->assertEquals('column', $columns->get(0)->getKey());
        $this->assertEquals('second', $columns->get(1)->getKey());
        $this->assertEquals('Label', $columns->get(0)->getLabel());
        $this->assertEquals('The Label', $columns->get(1)->getLabel());
    }

    /** @test */
    public function itCanAddAResourceToAGrid()
    {
        $this->grid->setResource('my resource as a string');

        $this->assertEquals('my resource as a string', $this->provider->getResource());
    }

    /** @test */
    public function itCanDetectIfAGridHasSortableFields()
    {
        $this->assertFalse($this->grid->isSortable());

        $this->grid->addColumn('column', 'label', function (Column $c) {
            $c->sortable();
        });
        $this->grid->addColumn('column2', 'label2');
        $this->assertTrue($this->grid->isSortable());
    }

    /** @test */
    public function itCanDetectIfAGridHasQueryableFields()
    {
        $this->assertFalse($this->grid->isQueryable());

        $this->grid->addColumn('column', 'label', function (Column $c) {
            $c->queryable();
        });
        $this->grid->addColumn('column2', 'label2');
        $this->assertTrue($this->grid->isQueryable());
    }

    /** @test */
    public function itCanDetectIfAGridHasFilterableFields()
    {
        $this->assertFalse($this->grid->isFilterable());

        $this->grid->addColumn('column', 'label', function (Column $c) {
            $c->filterable();
        });
        $this->grid->addColumn('column2', 'label2');
        $this->assertTrue($this->grid->isFilterable());
    }

    /** @test */
    public function itCanFilterGridRows()
    {
        $this->grid->addQueryParams([
            'filter' => [
                'name' => 'hello',
            ],
        ]);

        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->filterable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(FilterCollection::class, $this->provider->getFilters());
        $this->assertCount(1, $this->provider->getFilters());
        $this->assertInstanceOf(Filter::class, $this->provider->getFilters()->get(0));
        $this->assertEquals('name', $this->provider->getFilters()->get(0)->getField());
        $this->assertEquals('hello', $this->provider->getFilters()->get(0)->getValue());
    }

    /** @test */
    public function itCanFilterMultipleGridRows()
    {
        $this->grid->addQueryParams([
            'filter' => [
                'name'       => 'hello',
                'created_at' => 'hello',
            ],
        ]);

        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->filterable();
        });
        $this->grid->addColumn('created_at', 'Label Name', function (Column $c) {
            $c->filterable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(FilterCollection::class, $this->provider->getFilters());
        $this->assertCount(2, $this->provider->getFilters());
        $this->assertInstanceOf(Filter::class, $this->provider->getFilters()->get(0));
        $this->assertEquals('name', $this->provider->getFilters()->get(0)->getField());
        $this->assertEquals('hello', $this->provider->getFilters()->get(0)->getValue());
        $this->assertEquals('created_at', $this->provider->getFilters()->get(1)->getField());
        $this->assertEquals('hello', $this->provider->getFilters()->get(1)->getValue());
    }

    /** @test */
    public function itCanParseMultipleFiltersForOneField()
    {
        $this->grid->addQueryParams([
            'filter' => [
                'name'       => 'hello,itsme',
                'created_at' => 'hello',
            ],
        ]);

        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->filterable();
        });
        $this->grid->addColumn('created_at', 'Label Name', function (Column $c) {
            $c->filterable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(FilterCollection::class, $this->provider->getFilters());
        $this->assertCount(3, $this->provider->getFilters());
        $this->assertInstanceOf(Filter::class, $this->provider->getFilters()->get(0));
        $this->assertEquals('name', $this->provider->getFilters()->get(0)->getField());
        $this->assertEquals('hello', $this->provider->getFilters()->get(0)->getValue());
        $this->assertEquals('name', $this->provider->getFilters()->get(1)->getField());
        $this->assertEquals('itsme', $this->provider->getFilters()->get(1)->getValue());
        $this->assertEquals('created_at', $this->provider->getFilters()->get(2)->getField());
        $this->assertEquals('hello', $this->provider->getFilters()->get(2)->getValue());
    }

    /** @test */
    public function itCanQueryGridRows()
    {
        $this->grid->addQueryParams([
            'query' => 'hello',
        ]);
        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->queryable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(Query::class, $this->provider->getQuery());
        $this->assertEquals('hello', $this->provider->getQuery()->getValue());
    }

    /** @test */
    public function itCanSortGridRows()
    {
        $this->grid->addQueryParams([
            'sort' => 'name',
        ]);
        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->sortable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(SortCollection::class, $this->provider->getSorts());
        $this->assertEquals('name', $this->provider->getSorts()->get(0)->field());
    }

    /** @test */
    public function itCanSortMultipleRows()
    {
        $this->grid->addQueryParams([
            'sort' => 'name,created_at',
        ]);
        $this->grid->addColumn('name', 'Label Name', function (Column $c) {
            $c->sortable();
        });
        $this->grid->addColumn('created_at', 'Created On', function (Column $c) {
            $c->sortable();
        });

        $this->grid->getResults();

        $this->assertInstanceOf(SortCollection::class, $this->provider->getSorts());
        $this->assertEquals('name', $this->provider->getSorts()->get(0)->field());
        $this->assertEquals('created_at', $this->provider->getSorts()->get(1)->field());
        $this->assertCount(2, $this->provider->getSorts());
    }

    /** @test */
    public function itReturnsResultsMappedByColumns()
    {
        $this->grid
            ->addColumn('name', 'Name', function (Column $c) {
                $c->formatter(function ($value) {
                    return 'prepend-'.$value;
                });
            })
            ->addColumn('age', 'Age', function (Column $c) {
                $c->formatter(function ($value) {
                    return $value.' Years';
                });
            });
        $this->provider->setData([
            ['name' => 'Andrew', 'age' => 34],
            ['name' => 'Rachel', 'age' => 27],
        ]);

        $gridResult = $this->grid->getResults();
        $rows = $gridResult->toArray()['items'];
        $this->assertInstanceOf(GridResult::class, $gridResult);
        $this->assertCount(2, $rows);
        $this->assertEquals('prepend-'.'Andrew', $rows[0]['name']);
        $this->assertEquals('prepend-'.'Rachel', $rows[1]['name']);
        $this->assertEquals('34 Years', $rows[0]['age']);
        $this->assertEquals('27 Years', $rows[1]['age']);
    }

    /** @test
     * @expectedException \Willishq\QueryGrid\Exceptions\ColumnKeyNotInRowException
     */
    public function itHandlesColumnKeysNotExistingOnARow()
    {
        $this->grid
            ->addColumn('name', 'Name')
            ->addColumn('ager', 'Age');
        $this->provider->setData([
            ['name' => 'Andrew', 'age' => 34],
        ]);

        $this->grid->getResults();
    }

    /**
     * @test
     * @expectedException \Willishq\QueryGrid\Exceptions\ColumnNotFilterableException
     */
    public function itCanOnlyFilterFilterableColumns()
    {
        $this->grid->addQueryParams([
            'filter' => [
                'name' => 'nope',
            ],
        ]);
        $this->grid->addColumn('name', 'Label Name');
        $this->grid->addColumn('age', 'Label age', function (Column $c) {
            $c->filterable();
        });

        $this->grid->getResults();
    }

    /**
     * @test
     * @expectedException \Willishq\QueryGrid\Exceptions\ColumnNotSortableException
     */
    public function itCanOnlySortSortableColumns()
    {
        $this->grid->addQueryParams([
            'sort' => 'name,age',
        ]);
        $this->grid->addColumn('name', 'Label Name');
        $this->grid->addColumn('age', 'Label age', function (Column $c) {
            $c->sortable();
        });
        $this->grid->getResults();
    }
}
