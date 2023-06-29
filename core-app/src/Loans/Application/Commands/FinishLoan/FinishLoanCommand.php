<?php

namespace Core\Loans\Application\Commands\FinishLoan;

use Core\Common\Application\Bus\Command\Command;

class FinishLoanCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
    )
    {}
}
