<?php

namespace Willishq\QueryGrid\Columns;

class Filter
{
    const STARTS_WITH = 'st';
    const ENDS_WITH = 'enw';
    const CONTAINS = 'con';
    const EXACT = 'exa';
    const LESS_THAN = 'lt';
    const LESS_THAN_OR_EQUAL = 'lte';
    const GREATER_THAN = 'gt';
    const GREATER_THAN_OR_EQUAL = 'gte';
    const MATCH_ONE_OPTION = 'm1';
    const MATCH_MANY_OPTIONS = 'mn';
    /** @var string */
    private $type;
    private $options = [];
    private $name = '';

    public function __construct(string $type)
    {
        if (!in_array($type, self::getTypes())) {
            throw FilterException::unknownFilterType($type);
        }
        $this->type = $type;
    }

    public function toArray(): array
    {
        $result = [
            'type' => $this->type,
            'name' => $this->name,
        ];
        if (!empty($this->options)) {
            $result['options'] = $this->options;
        }
        return $result;
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
