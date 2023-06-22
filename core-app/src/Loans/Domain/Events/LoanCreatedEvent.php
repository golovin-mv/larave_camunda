<?php

namespace Core\Loans\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Loans\Domain\Loan;
use Core\Loans\Domain\LoanId;

class LoanCreatedEvent extends DomainEvent
{
    public function __construct(
        readonly Loan $loan,
    )
    {}
}
