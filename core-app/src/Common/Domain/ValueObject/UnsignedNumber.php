<?php

namespace Core\Common\Domain\ValueObject;

use Core\Common\Domain\DomainException;

class UnsignedNumber extends ValueObject
{
    public function __construct(int $value)
    {
        if($value < 0) {
            throw new DomainException('The value must be greater than zero');
        }

        parent::__construct($value);
    }
}
