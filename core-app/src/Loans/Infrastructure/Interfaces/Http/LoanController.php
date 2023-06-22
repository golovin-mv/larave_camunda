<?php

namespace Core\Loans\Infrastructure\Interfaces\Http;

use App\Http\Controllers\Controller;
use Core\Common\Application\Bus\CommandBus;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommand;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function __construct(
        private CommandBus $bus,
    )
    {}

    public function createLoan(Request $request)
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
}
