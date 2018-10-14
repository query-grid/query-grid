<?php

namespace Tests;

use QueryGrid\QueryGrid\RowCollection;

class RowCollectionTest extends TestCase
{
    /** @test */
    public function itIsPopulated()
    {
        $collection = new RowCollection();
        $rows = [
            ['salutation' => 'Hello'],
            ['salutation' => 'Hey'],
            ['salutation' => 'Hi'],
            ['salutation' => 'Howdy'],
        ];
        $collection->populate($rows);

        $this->assertEquals($rows, $collection->all());
    }

    public function itIsMapped()
    {
        $collection = new RowCollection();
        $rows = [
            ['salutation' => 'Hello'],
            ['salutation' => 'Hey'],
            ['salutation' => 'Hi'],
            ['salutation' => 'Howdy'],
        ];

        $collection->populate($rows);
        $mapped = $collection->map(function ($row) {
            $row['test'] = 1;
            return $row;
        });

        $this->assertEquals([
            [
                'salutation' => 'Hello',
                'test' => 1,
            ],
            [
                'salutation' => 'Hey',
                'test' => 1,
            ],
            [
                'salutation' => 'Hi',
                'test' => 1,
            ],
            [
                'salutation' => 'Howdy',
                'test' => 1,
            ],
        ], $mapped->all());
    }
}
