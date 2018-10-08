<?php

namespace Tests\Grid;

use Tests\Fixtures\DataProviderSpy;
use Tests\TestCase as BaseTestCase;
use Willishq\QueryGrid\Grid;

class TestCase extends BaseTestCase
{

    /**
     * @var DataProviderSpy
     */
    protected $dataProvider;

    public function setUp()
    {
        $this->dataProvider = new DataProviderSpy();
    }

    /**
     * @param array $queryParams
     * @return Grid
     */
    protected function itHasAGridInstance(array $queryParams = []): Grid
    {
        return new Grid($this->dataProvider, $queryParams);
    }
}
