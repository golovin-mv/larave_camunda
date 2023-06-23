<?php

namespace Core\Loans\Infrastructure\Interfaces\Http;

use App\Http\Controllers\Controller;
use Core\Common\Application\Bus\Command\CommandBus;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommand;
use Core\Loans\Application\Commands\EditPassport\EditPassportCommand;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(
        private CommandBus $bus,
    )
    {}

    public function createLoan(Request $request): void
    {
        $this->bus->dispatch(
            new CreateLoanCommand(
                $request->input('firstName'),
                $request->input('lastName'),
                $request->input('middleName'),
                $request->input('amount'),
                $request->input('interval'),
            )
        );
    }

    public function editLoanPassport(Request $request)
    {
        $this->bus->dispatch(
            new EditPassportCommand(
                $request->input('id'),
                $request->input('number'),
            )
        );
    }
}
