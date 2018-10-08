<?php

namespace Willishq\QueryGrid\Contracts;

interface DataProvider
{
    public function setResource(string $resource);

    public function get();
}
