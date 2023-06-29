<?php

namespace Core\Scoring\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Scoring\Domain\Review;

class PrescoringReviewRejected implements DomainEvent
{
    public function __construct(
        public readonly Review $review,
    )
    {}
}
