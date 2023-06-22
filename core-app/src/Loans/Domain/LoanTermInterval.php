<?php

namespace Core\Loans\Domain;

use Carbon\CarbonInterval;

class LoanTermInterval
{
    public function __construct(
        private readonly CarbonInterval $interval
    )
    {}

    public static function fromMonthCount(int $monthCount): LoanTermInterval
    {
        return new self(new CarbonInterval("{$monthCount}M"));
    }

    public static function fromDayCount(int $dayCount): LoanTermInterval
    {
        return  new self(new CarbonInterval("${$dayCount}D"));
    }

    public function __toString(): string
    {
        return "LoanTermInterval[value={$this->interval}]";
    }

    public function equals(LoanTermInterval $other) : bool
    {
        return $this->interval->compare($other->interval);
    }

    public function getMonthCount(): int
    {
        return $this->interval->m;
    }

    public function getDaysCount(): int
    {
        return $this->interval->d;
    }
}
