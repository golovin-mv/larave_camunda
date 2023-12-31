<?php

namespace Core\Loans\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Loans\Domain\Loan;

class LoanCreatedEvent implements DomainEvent
{
    public function __construct(
        readonly Loan $loan,
    )
    {}
}
