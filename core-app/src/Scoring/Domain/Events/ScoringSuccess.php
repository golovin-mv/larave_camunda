<?php

namespace Core\Scoring\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Loans\Domain\LoanId;
use Core\Scoring\Domain\Review;

class ScoringSuccess implements DomainEvent
{
    public function __construct(
        public readonly Review $review,
        public readonly LoanId $id,
    )
    {}
}
