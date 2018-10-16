<?php

namespace Tests\Grid;

use QueryGrid\QueryGrid\Columns\Column;
use QueryGrid\QueryGrid\Columns\ColumnCollection;
use QueryGrid\QueryGrid\Columns\Formatters\Date;
use QueryGrid\QueryGrid\GridResult;
use QueryGrid\QueryGrid\RowCollection;

class GridResultTest extends \Tests\TestCase
{
    /** @test */
    public function itGetsColumns()
    {
        $columns = new ColumnCollection();
        $result = new GridResult($columns);

        $resultColumns = $result->getColumns();

        $this->assertEquals($columns, $resultColumns);
    }

    /** @test */
    public function itGetsRows()
    {
        $columns = new ColumnCollection();
        $columns->add(new Column('name', 'Name'));
        $result = new GridResult($columns);
        $result->setRows([
            [
                'name' => 'Andrew',
                'email' => 'andrew@example.com',
                'created_at' => '1920-05-20',
            ],
            [
                'name' => 'Rachel',
                'email' => 'rachel@example.com',
                'created_at' => '1940-05-20',
            ],
        ]);

        $this->assertInstanceOf(RowCollection::class, $result->getRows());
        $this->assertCount(2, $result->getRows());
        $this->assertEquals([
            [
                'name' => 'Andrew',
            ],
            [
                'name' => 'Rachel'
            ]
        ], $result->getRows()->all());
    }

    /** @test */
    public function itFormatsRows()
    {
        $columns = new ColumnCollection();
        $column = new Column('name', 'Name');
        $column->withFormat(function ($value) {
            return 'NAME.' . $value;
        });
        $columns->add($column);

        $column = new Column('startedOn', 'Name');
        $column->fromField('created_at');
        $column->withFormat(new Date('Y-m-d', 'd/m/Y'));
        $columns->add($column);
        $result = new GridResult($columns);
        $result->setRows([
            [
                'name' => 'Andrew',
                'email' => 'andrew@example.com',
                'created_at' => '1920-05-20',
            ],
            [
                'name' => 'Rachel',
                'email' => 'rachel@example.com',
                'created_at' => '1940-05-20',
            ],
        ]);

        $this->assertInstanceOf(RowCollection::class, $result->getRows());
        $this->assertCount(2, $result->getRows());
        $this->assertEquals([
            [
                'name' => 'NAME.Andrew',
                'startedOn' => '20/05/1920',
            ],
            [
                'name' => 'NAME.Rachel',
                'startedOn' => '20/05/1940',

            ]
        ], $result->getRows()->all());
    }


    /** @test */
    public function itParsesNestedValues()
    {
        $columns = new ColumnCollection();

        $column = new Column('name', 'Name');
        $column->fromField('name.first');

        $columns->add($column);

        $result = new GridResult($columns);

        $result->setRows([
            [
                'name' => [
                    'first' => 'Andrew',
                ],
            ],
            [
                'name' => [
                    'first' => 'Rachel',
                ],
            ],
        ]);

        $this->assertInstanceOf(RowCollection::class, $result->getRows());
        $this->assertCount(2, $result->getRows());
        $this->assertEquals([
            [
                'name' => 'Andrew',
            ],
            [
                'name' => 'Rachel',

            ]
        ], $result->getRows()->all());
    }

    /** @test */
    public function itFailsQuietlyForMissingValues()
    {
        $columns = new ColumnCollection();

        $column = new Column('name', 'Name');
        $column->fromField('name.last');

        $columns->add($column);

        $result = new GridResult($columns);

        $result->setRows([
            [
                'name' => [
                    'first' => 'Andrew',
                ],
            ],
            [
                'name' => [
                    'first' => 'Rachel',
                ],
            ],
        ]);

        $this->assertInstanceOf(RowCollection::class, $result->getRows());
        $this->assertCount(2, $result->getRows());
        $this->assertEquals([
            [
                'name' => '',
            ],
            [
                'name' => '',

            ]
        ], $result->getRows()->all());
    }

    /** @test */
    public function itHandlesMissingRows()
    {
        $columns = new ColumnCollection();
        $column = new Column('name', 'Name');
        $column->withFormat(function ($value) {
            return 'NAME.' . $value;
        });
        $columns->add($column);
        $result = new GridResult($columns);
        $result->setRows([['name' => null]]);

        $rows = $result->getRows();

        $this->assertInstanceOf(RowCollection::class, $result->getRows());
        $this->assertEquals([
            [
                'name' => null,
            ]
        ], $rows->all());
    }
}
