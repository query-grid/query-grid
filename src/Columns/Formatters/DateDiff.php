<?php

namespace Willishq\QueryGrid\Columns\Formatters;

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

    public function __construct(string $dateFormat, string $format)
    {
        $this->dateFormat = $dateFormat;
        $this->format = $format;
    }

    public function withFromDate(string $date): DateDiff
    {
        $this->from = $date;
        return $this;
    }

    public function __invoke(string $date): string
    {
        $from = $this->createDate($this->from);
        if ($from === false) {
            return '';
        }

        $to = $this->createDate($date);
        if ($to === false) {
            return '';
        }
        return $from->diff($to)->format($this->format);
    }

    protected function createDate(string $date)
    {
        return DateTime::createFromFormat($this->dateFormat, $date);
    }
}
