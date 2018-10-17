<?php

namespace QueryGrid\QueryGrid\Columns\Formatters;

class Date
{
    /**  @var string */
    private $from;
    /**  @var string */
    private $to;

    /**
     * Date constructor.
     * @param string $from
     * @param string $to
     */
    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @param string $date
     * @return string
     */
    public function __invoke(string $date): string
    {
        $dateTime =  \DateTime::createFromFormat($this->from, $date);
        if ($dateTime !== false) {
            return $dateTime->format($this->to);
        }
        return '';
    }
}
