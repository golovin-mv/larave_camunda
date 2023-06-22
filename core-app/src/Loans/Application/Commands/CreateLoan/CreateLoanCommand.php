<?php

namespace Core\Loans\Application\Commands\CreateLoan;

use Core\Common\Application\Bus\Command;

class CreateLoanCommand implements Command
{
    public function __construct(
        readonly string $firstName,
        readonly string $lastName,
        readonly string | null $middleName,
        readonly int $amount,
        readonly int $interval,
    )
    {}
}
