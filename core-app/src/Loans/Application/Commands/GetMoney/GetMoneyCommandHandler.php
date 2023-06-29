<?php

namespace Core\Loans\Application\Commands\GetMoney;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;

class GetMoneyCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly LoanRepository $loanRepository,
    )
    {}

    public function __invoke(GetMoneyCommand $command)
    {
        $loan = $this->loanRepository->getById(
            new LoanId($command->loanId)
        );

        $loan->getMoney();

        $this->loanRepository->save($loan);
    }
}
