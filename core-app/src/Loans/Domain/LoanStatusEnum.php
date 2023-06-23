<?php

namespace Core\Loans\Domain;

enum LoanStatusEnum: string
{
    case IN_WORK = 'in_work';
    case SCORING = 'scoring';
    case REJECTED = 'rejected';
}
