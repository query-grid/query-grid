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
    /** @var int  */
    private $type;
    private $options = [];

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

    public function addOption(string $key, string $value = null)
    {
        $value = $value ?? $key;
        $this->options[] = compact('key', 'value');
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
