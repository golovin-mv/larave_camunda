<?php

namespace Core\Loans\Application\Commands\CreateLoan;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Domain\DomainException;
use Core\Loans\Domain\ClientName;
use Core\Loans\Domain\Loan;
use Core\Loans\Domain\LoanAmount;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Domain\LoanTermInterval;
use Illuminate\Support\Facades\Log;

class CreateLoanCommandHandler implements CommandHandler
{
    public function __construct(
        private LoanRepository $repository,
        private EventBus $eventBus,
    )
    {}

    /**
     * @param CreateLoanCommand $command
     * @return void
     * @throws DomainException
     */
    public function handle(CreateLoanCommand $command): Loan
    {
        $loan = Loan::createLoan(
            new ClientName(collect([
                'firstName' => $command->firstName,
                'lastName' => $command->lastName,
                'middleName' => $command->middleName,
            ])),
            new LoanAmount($command->amount),
            LoanTermInterval::fromMonthCount($command->interval),
            $this->repository->getNextId(),
        );

        $this->repository->save($loan);

        $this->eventBus->publish($loan->pullEvents()->toArray());

        return $loan;
    }
}
