<?php

namespace Core\Loans\Application\Commands\RejectLoan;

use Core\Common\Application\Bus\Command\Command;

class RejectLoanCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
    )
    {}
}
