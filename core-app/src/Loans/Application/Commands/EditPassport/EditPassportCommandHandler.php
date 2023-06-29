<?php

namespace Core\Loans\Application\Commands\EditPassport;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Domain\DomainException;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Domain\Passport;
use Illuminate\Support\Facades\DB;

class EditPassportCommandHandler implements CommandHandler
{
    public function __construct(
        private readonly LoanRepository $repository,
        private readonly EventBus $bus,
    )
    {}

    /**
     * @param EditPassportCommand $command
     * @return void
     */
    public function handle(EditPassportCommand $command): void
    {
        DB::transaction(function () use ($command) {
            $loan = $this->repository->getById(
                new LoanId($command->loanId),
            );

            $loan->editPassport(
                Passport::fromSeriesAndNumberString($command->passportNumber)
            );

            $this->repository->save($loan);
            $this->bus->publish($loan->pullEvents()->toArray());
        });
    }
}
