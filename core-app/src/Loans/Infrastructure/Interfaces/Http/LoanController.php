<?php

namespace Core\Loans\Infrastructure\Interfaces\Http;

use App\Http\Controllers\Controller;
use Core\Common\Application\Bus\Command\CommandBus;
use Core\Loans\Application\Commands\AddAddress\AddAddressCommand;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommand;
use Core\Loans\Application\Commands\EditPassport\EditPassportCommand;
use Core\Loans\Application\Commands\FinishLoan\FinishLoanCommand;
use Core\Loans\Domain\LoanId;
use Core\Loans\Infrastructure\Interfaces\Http\Dto\AddAddressRequest;
use Core\Loans\Infrastructure\Interfaces\Http\Dto\EditLoanPassportDto;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(
        private CommandBus $bus,
    )
    {}

    public function createLoan(Request $request)
    {
        $loan = $this->bus->dispatch(
            new CreateLoanCommand(
                $request->input('firstName'),
                $request->input('lastName'),
                $request->input('middleName'),
                $request->input('amount'),
                $request->input('interval'),
            )
        );

        return [
            'id' => $loan->getId()->valueOf(),
        ];
    }

    public function editLoanPassport(EditLoanPassportDto $request, string $id): void
    {
        $this->bus->dispatch(
            new EditPassportCommand(
                $id,
                $request->input('number'),
            )
        );
    }

    public function addAddress(AddAddressRequest $request, string $id)
    {
        $this->bus->dispatch(
            new AddAddressCommand(
                $id,
                $request->input('address'),
                $request->input('postalCode'),
            )
        );
    }

    public function finish(Request $request, string $id)
    {
        $this->bus->dispatch(
            new FinishLoanCommand(
                $id,
            )
        );
    }
}
