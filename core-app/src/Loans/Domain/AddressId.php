<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\ValueObject\ValueObject;

class AddressId extends ValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
