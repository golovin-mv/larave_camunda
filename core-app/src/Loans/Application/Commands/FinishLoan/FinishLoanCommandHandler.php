<?php

namespace Core\Loans\Application\Commands\FinishLoan;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Domain\DomainException;
use Core\Loans\Domain\Loan;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;

class FinishLoanCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly LoanRepository $repository,
        private readonly EventBus $eventBus
    )
    {}

    /**
     * @param FinishLoanCommand $command
     * @return void
     * @throws DomainException
     */
    public function __invoke(FinishLoanCommand $command): Loan
    {
        $loan = $this->repository->getById(
            new LoanId($command->loanId),
        );

        $loan->finishLoan();

        $this->repository->save($loan);

        $this->eventBus->publish($loan->pullEvents()->toArray());

        return $loan;
    }
}
