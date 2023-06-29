<?php

namespace Core\Scoring\Infrastructure\Eloquent\Repositories;

use Core\Scoring\Domain\Review;
use Core\Scoring\Domain\ReviewId;
use Core\Scoring\Domain\ReviewRepository;
use Ramsey\Uuid\Uuid;

class FakeReviewRepository implements ReviewRepository
{
    public function nextId(): ReviewId
    {
        return new ReviewId(Uuid::uuid4());
    }

    public function save(Review $review): Review
    {
        return $review;
    }

}
