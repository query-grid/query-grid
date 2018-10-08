<?php

namespace Tests\Grid;

use Willishq\QueryGrid\Columns\Column;
use Willishq\QueryGrid\Columns\ColumnCollection;
use Willishq\QueryGrid\GridResult;

class GridResultTest extends \Tests\TestCase
{
    /** @test */
    public function itCanGetTheGridColumns()
    {
        $columns = new ColumnCollection();
        $result = new GridResult($columns);

        $resultColumns = $result->getColumns();

        $this->assertEquals($columns, $resultColumns);
    }

    /** @test */
    public function itCanGetTheResultData()
    {
        $columns = new ColumnCollection();
        $columns->add(new Column('name', 'Name'));
        $result = new GridResult($columns);
        $result->setData([
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

        $this->assertCount(2, $result->getRows());
        $this->assertEquals([
            [
                'name' => 'Andrew',
            ],
            [
                'name' => 'Rachel'
            ]
        ], $result->getRows());
    }

    /** @test */
    public function itCanGetFormattedResultData()
    {

        $columns = new ColumnCollection();
        $column = new Column('name', 'Name');
        $column->withFormat(function ($value) {
            return 'NAME.' . $value;
        });
        $columns->add($column);

        $column = new Column('startedOn', 'Name');
        $column->fromField('created_at');
        $column->withFormat(function ($value) {
            return \DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y');
        });
        $columns->add($column);
        $result = new GridResult($columns);
        $result->setData([
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
        ], $result->getRows());
    }

    /** @test */
    public function itHandlesFormattingMissingData()
    {
        $columns = new ColumnCollection();
        $column = new Column('name', 'Name');
        $column->withFormat(function ($value) {
            return 'NAME.' . $value;
        });
        $columns->add($column);
        $result = new GridResult($columns);
        $result->setData([['name' => null]]);

        $data = $result->getRows();
        $this->assertEquals([
            [
                'name' => null,
            ]
        ], $data);
    }

}
