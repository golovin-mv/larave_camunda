<?php

namespace Core\Loans\Domain;

enum LoanStatusEnum
{
    case IN_WORK;
    case SCORING;
    case DECLINE;
    case REJECTED;
}
