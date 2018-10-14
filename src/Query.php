<?php

namespace QueryGrid\QueryGrid;

class Query
{
    /** @var string */
    private $query;
    /** @var array */
    private $fields;

    public function __construct(string $query, array $fields)
    {
        $this->query = $query;
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function toArray()
    {
        return [
            'query' => $this->getQuery(),
            'fields' => $this->getFields(),
        ];
    }
}
