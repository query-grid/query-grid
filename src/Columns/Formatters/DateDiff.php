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
    /** @var \DateTime */
    private $fromDate;

    public function __construct(string $dateFormat, string $format)
    {
        $this->dateFormat = $dateFormat;
        $this->fromDate = new \DateTime();
        $this->format = $format;
    }

    public function withFromDate(string $date): DateDiff
    {
        $this->fromDate = $this->createDate($date);
        return $this;
    }

    public function __invoke(string $date): string
    {
        if (! $this->fromDate instanceof DateTime) {
            return '';
        }

        $to = $this->createDate($date);

        if (! $to instanceof DateTime) {
            return '';
        }
        return $this->fromDate->diff($to)->format($this->format);
    }

    protected function createDate(string $date)
    {
        return DateTime::createFromFormat($this->dateFormat, $date);
    }
}
