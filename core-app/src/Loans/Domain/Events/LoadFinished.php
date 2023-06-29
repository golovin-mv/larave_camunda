<?php

namespace Core\Loans\Domain\Events;

use Core\Common\Domain\DomainEvent;
use Core\Loans\Domain\Loan;

class LoadFinished implements DomainEvent
{
    public function __construct(
        public readonly Loan $loan
    )
    {}
}
