<?php

namespace Tests\Fixtures;

use Willishq\QueryGrid\Contracts\DataProvider;

class DataProviderSpy implements DataProvider
{

    private $resource;

    public $values = [];

    public function getResource(): string
    {
        return $this->resource;
    }

    public function setResource(string $resource)
    {
        $this->resource = $resource;
    }

    public function setValues($data)
    {
        $this->values = $data;
    }

    public function get(): array
    {
        return $this->values;
    }
}
