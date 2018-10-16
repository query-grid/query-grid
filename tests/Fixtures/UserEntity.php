<?php

namespace Tests\Fixtures;

use ArrayAccess;

class UserEntity implements ArrayAccess
{
    private $attributes;

    public function __construct($name, $email, $created_at)
    {
        $this->attributes = compact('name', 'email', 'created_at');
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset];
    }

    public function offsetSet($offset, $value)
    {
    }

    public function offsetUnset($offset)
    {
    }
}
