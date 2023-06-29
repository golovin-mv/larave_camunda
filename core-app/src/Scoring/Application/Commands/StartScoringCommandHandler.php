<?php

namespace Core\Scoring\Application\Commands;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Loans\Domain\LoanId;
use Core\Scoring\Domain\Review;
use Core\Scoring\Domain\ReviewRepository;

class StartScoringCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly ReviewRepository $repository,
        private readonly EventBus $eventBus
    )
    {}

    public function __invoke(StartScoringCommand $command)
    {
        $review = Review::scoreLoan(
            $this->repository->nextId(),
            new LoanId($command->loanId),
            $command->firstName,
            $command->sum,
        );

        $this->eventBus->publish($review->pullEvents()->toArray());
    }
}
