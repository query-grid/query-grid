<?php

namespace QueryGrid\QueryGrid\Columns;

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
    /** @var array  */
    private $options = [];
    /** @var string  */
    private $name = '';
    /** @var mixed */
    private $field;

    /**
     * Filter constructor.
     * @param string $type
     * @throws FilterException
     * @return void
     */
    public function __construct(string $type)
    {
        if (!in_array($type, self::getTypes(), true)) {
            throw FilterException::unknownFilterType($type);
        }
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [
            'type' => $this->type,
            'name' => $this->name,
        ];
        if (count($this->options) > 0) {
            $result['options'] = $this->options;
        }
        return $result;
    }

    /**
     * @return array
     */
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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $value
     * @param string|null $label
     * @return void
     */
    public function addOption(string $value, string $label = null)
    {
        $label = $label ?? $value;
        $this->options[] = compact('value', 'label');
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $field
     * @return void
     */
    public function setField(string $field)
    {
        $this->field = $field;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }
}
