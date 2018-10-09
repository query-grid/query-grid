<?php

namespace Tests;

use Willishq\QueryGrid\RowCollection;

class RowCollectionTest extends TestCase
{
    /** @test */
    public function itIsPopulated()
    {
        $collection = new RowCollection();
        $data = [
            ['salutation' => 'Hello'],
            ['salutation' => 'Hey'],
            ['salutation' => 'Hi'],
            ['salutation' => 'Howdy'],
        ];
        $collection->populate($data);

        $this->assertEquals($data, $collection->all());
    }
}
