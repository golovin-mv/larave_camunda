<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\ValueObject\UnsignedNumber;

class LoanAmount extends UnsignedNumber
{
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new DomainException('The loan amount must be less than 0');
        }

        parent::__construct($value);
    }
}
