<?php

namespace Core\Loans\Domain;

use Core\Common\Domain\DomainException;
use Core\Common\Domain\ValueObject\ValueObject;

class PostalCode extends ValueObject
{
    public function __construct(string $value)
    {
        if (!preg_match('/^\d{6}$/', $value))
        {
            throw new DomainException('The postal code number should be in the format 000000.');
        }
        parent::__construct($value);
    }
}
