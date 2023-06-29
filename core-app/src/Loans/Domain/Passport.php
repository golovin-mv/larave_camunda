<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\ValueObject\ValueObject;

//TODO to nullable
class Passport
{
    public function __construct(
        private readonly string $series,
        private readonly string $number,
    )
    {}

    public static function fromSeriesAndNumberString(string $passportNumber): Passport
    {
        if (!preg_match('/^\d{4}\s\d{6}$/m', $passportNumber))
        {
            throw new DomainException('The passport number should be in the format 0000 000000.');
        }

        $explodedNumber = explode(" ", $passportNumber);

        return new self($explodedNumber[0], $explodedNumber[1]);
    }

    public function equals(Passport $other): bool
    {
        return
            $this->series === $other->series
            && $this->number === $other->number;
    }


    /**
     * @return string
     */
    public function getSeries(): string
    {
        return $this->series;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }
}
