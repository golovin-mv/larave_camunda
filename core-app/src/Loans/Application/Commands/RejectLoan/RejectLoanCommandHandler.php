<?php

namespace Core\Loans\Application\Commands\RejectLoan;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;

class RejectLoanCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly LoanRepository $repository,
    )
    {}

    public function __invoke(RejectLoanCommand $command): void
    {
        $loan = $this->repository->getById(
            new LoanId($command->loanId),
        );

        $loan->rejectLoan();

        $this->repository->save($loan);
    }
}
