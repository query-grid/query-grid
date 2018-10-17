<?php

namespace QueryGrid\QueryGrid\Columns\Formatters;

use DateTime;

class DateDiff
{
    /**
     * @var string
     */
    private $dateFormat;
    /**
     * @var string
     */
    private $format;
    /** @var string */
    private $from;

    /**
     * DateDiff constructor.
     * @param string $dateFormat
     * @param string $format
     */
    public function __construct(string $dateFormat, string $format)
    {
        $this->dateFormat = $dateFormat;
        $this->format = $format;
    }

    /**
     * @param string $date
     * @return DateDiff
     */
    public function withFromDate(string $date): DateDiff
    {
        $this->from = $date;
        return $this;
    }

    /**
     * @param string $date
     * @return string
     */
    public function __invoke(string $date): string
    {
        $to = $this->createDate($date);
        $from = $this->createDate($this->from);

        if ($from instanceof DateTime && $to instanceof DateTime) {
            return $from->diff($to)->format($this->format);
        }

        return '';
    }

    /**
     * @param string $date
     * @return bool|DateTime
     */
    protected function createDate(string $date)
    {
        return DateTime::createFromFormat($this->dateFormat, $date);
    }
}
