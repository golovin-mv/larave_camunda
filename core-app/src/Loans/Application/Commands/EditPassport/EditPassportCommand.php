<?php

namespace Core\Loans\Application\Commands\EditPassport;

use Core\Common\Application\Bus\Command\Command;

class EditPassportCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
        public readonly string $passportNumber,
    )
    {}
}
