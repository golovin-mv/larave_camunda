<?php

namespace Core\Scoring\Domain;

use Core\Common\Domain\ValueObject\ValueObject;

class ReviewType extends ValueObject
{
    public function __construct(ReviewTypeEnum $value)
    {
        parent::__construct($value);
    }

    public function valueOf(): mixed
    {
        return $this->value->value;
    }
}
