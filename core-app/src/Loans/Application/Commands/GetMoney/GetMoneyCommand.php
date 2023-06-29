<?php

namespace Core\Loans\Application\Commands\GetMoney;

use Core\Common\Application\Bus\Command\Command;

class GetMoneyCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
    )
    {}
}
