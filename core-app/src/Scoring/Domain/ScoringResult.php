<?php

namespace Core\Scoring\Domain;

use Core\Common\Domain\ValueObject\ValueObject;

class ScoringResult extends ValueObject
{
    public function __construct(ScoringResultEnum $value)
    {
        parent::__construct($value);
    }

    public function valueOf(): mixed
    {
        return $this->value->value;
    }
}
