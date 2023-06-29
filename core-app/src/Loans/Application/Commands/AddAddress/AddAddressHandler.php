<?php

namespace Core\Loans\Application\Commands\AddAddress;

use Core\Common\Application\Bus\Command\CommandHandler;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Loans\Domain\Address;
use Core\Loans\Domain\AddressId;
use Core\Loans\Domain\AddressString;
use Core\Loans\Domain\LoanId;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Domain\PostalCode;
use Illuminate\Support\Facades\DB;

class AddAddressHandler implements CommandHandler
{
    public function __construct(
        private readonly LoanRepository $repository,
        private readonly EventBus $bus,
    )
    {}

    public function __invoke(AddAddressCommand $command): void
    {
        DB::transaction(function () use ($command) {
            $loan = $this->repository->getById(
                new LoanId($command->loanId),
            );

            $loan->addAddress(
                new Address(
                    $this->repository->nextAddressId(),
                    new PostalCode($command->postalCode),
                    new AddressString($command->address),
                ),
            );

            $this->repository->save($loan);

            $this->bus->publish($loan->pullEvents()->toArray());
        });
    }
}
