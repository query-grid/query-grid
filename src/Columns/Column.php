<?php

namespace Willishq\QueryGrid\Columns;

class Column
{
    private $key;
    private $label;
    private $field;
    private $formatter;

    public function __construct(string $key, string $label)
    {
        $this->key = $key;
        $this->field = $key;
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    public function fromField(string $field): self
    {
        $this->field = $field;
        return $this;
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function withFormat(callable $callable): self
    {
        $this->formatter = $callable;
        return $this;
    }

    public function format(string $value)
    {
        return ($this->formatter)($value);
    }

    public function hasFormat()
    {
        return isset($this->formatter);
    }

}
