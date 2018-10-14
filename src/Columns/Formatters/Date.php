<?php

namespace QueryGrid\QueryGrid\Columns\Formatters;

class Date
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function __invoke(string $date): string
    {
        $dateTime =  \DateTime::createFromFormat($this->from, $date);
        if ($dateTime) {
            return $dateTime->format($this->to);
        }
        return '';
    }
}
