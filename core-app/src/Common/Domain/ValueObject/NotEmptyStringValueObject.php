<?php

namespace Core\Common\Domain\ValueObject;

use Core\Common\Domain\DomainException;

abstract class NotEmptyStringValueObject extends ValueObject
{
    public function __construct(string $value)
    {
        if (trim($value) === '')
        {
            throw new DomainException(static::class.' can not be empty');
        }
        parent::__construct($value);
    }
}
