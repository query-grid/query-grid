<?php

namespace Willishq\QueryGrid;

class Filter
{
    const STARTS_WITH = 0;
    const ENDS_WITH = 1;
    const CONTAINS = 2;
    const EXACT = 3;
    const LESS_THAN = 4;
    const LESS_THAN_OR_EQUAL = 5;
    const GREATER_THAN = 6;
    const GREATER_THAN_OR_EQUAL = 7;
    const MATCH_ONE_OPTION = 8;
    const MATCH_MANY_OPTIONS = 9;
    /** @var int */
    private $type;
    private $options = [];
    private $name;

    public function __construct(int $type)
    {
        if (in_array($type, self::getTypes())) {
            $this->type = $type;
        }
    }


    public static function getTypes(): array
    {
        return [
            static::STARTS_WITH,
            static::ENDS_WITH,
            static::CONTAINS,
            static::EXACT,
            static::LESS_THAN,
            static::LESS_THAN_OR_EQUAL,
            static::GREATER_THAN,
            static::GREATER_THAN_OR_EQUAL,
            static::MATCH_ONE_OPTION,
            static::MATCH_MANY_OPTIONS,
        ];
    }

    public function getType()
    {
        return $this->type;
    }

    public function addOption(string $value, string $label = null)
    {
        $label = $label ?? $value;
        $this->options[] = compact('value', 'label');
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
