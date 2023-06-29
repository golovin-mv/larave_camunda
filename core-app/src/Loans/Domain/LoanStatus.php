<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\ValueObject\ValueObject;

class LoanStatus extends ValueObject
{
    public function __construct(LoanStatusEnum $value)
    {
        parent::__construct($value);
    }

    public function valueOf(): mixed
    {
        return $this->value->value;
    }


}
