<?php

namespace Core\Scoring\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Scoring\Domain\Review;

class PrescoringStarted implements DomainEvent
{
    public function __construct(Review $review)
    {}
}
