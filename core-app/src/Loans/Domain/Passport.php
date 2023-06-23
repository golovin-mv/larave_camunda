<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\ValueObject\ValueObject;

class Passport extends ValueObject
{
    private string $series;
    private string $number;

    public function __construct(string $passportNumber)
    {
        if (!preg_match('/^\d{4}\s\d{6}$/m', $passportNumber))
        {
            throw new DomainException('The passport number should be in the format 0000 000000.');
        }
        parent::__construct($passportNumber);

        $explodedNumber = explode(" ", $passportNumber);

        $this->series = $explodedNumber[0];
        $this->number = $explodedNumber[1];
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
