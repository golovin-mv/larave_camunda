<?php

namespace Core\Scoring\Domain;

use Core\Common\Domain\ValueObject\ValueObject;

class ReviewId extends ValueObject
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
