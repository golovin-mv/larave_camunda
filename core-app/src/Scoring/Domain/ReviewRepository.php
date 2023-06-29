<?php

namespace Core\Scoring\Domain;

interface ReviewRepository
{
    public function nextId(): ReviewId;
    public function save(Review $review): Review;
}
