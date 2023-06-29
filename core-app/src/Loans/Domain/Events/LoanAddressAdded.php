<?php

namespace Core\Loans\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Loans\Domain\AddressId;
use Core\Loans\Domain\Loan;

class LoanAddressAdded implements DomainEvent
{
    public function __construct(
        public readonly Loan $loan,
        public readonly AddressId $id,
    )
    {}
}
