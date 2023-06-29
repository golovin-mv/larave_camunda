<?php

namespace Core\Scoring\Application\Commands;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Loans\Domain\LoanId;
use Core\Scoring\Domain\Review;
use Core\Scoring\Domain\ReviewRepository;

class StartPrescoringReviewHandler implements CommandHandler
{
    public function __construct(
        private readonly ReviewRepository $repository,
        private readonly EventBus $bus,
    )
    {}

    public function __invoke(StartPrescoringReviewCommand $command)
    {
        $review = Review::prescoreLoan(
            $this->repository->nextId(),
            new LoanId($command->loanId),
            $command->firstName
        );

        $this->bus->publish($review->pullEvents()->toArray());
        $this->repository->save($review);

        sleep(5);

        $this->repository->save($review);
        $this->bus->publish($review->pullEvents()->toArray());

        return $review;
    }
}
