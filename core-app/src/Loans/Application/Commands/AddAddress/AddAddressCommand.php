<?php

namespace Core\Loans\Application\Commands\AddAddress;

use Core\Common\Application\Bus\Command\Command;

class AddAddressCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
        public readonly string $address,
        public readonly string $postalCode,
    )
    {}
}
