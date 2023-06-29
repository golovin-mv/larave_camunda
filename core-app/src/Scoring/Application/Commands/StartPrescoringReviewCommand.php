<?php

namespace Core\Scoring\Application\Commands;

use Core\Common\Application\Bus\Command\Command;

class StartPrescoringReviewCommand implements Command
{
    public function __construct(
        public readonly string $loanId,
        public readonly string $firstName,
    )
    {}
}
