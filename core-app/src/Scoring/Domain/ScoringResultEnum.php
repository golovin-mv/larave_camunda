<?php

namespace Core\Scoring\Domain;

enum ScoringResultEnum: string
{
    case SUCCESS = 'success';
    case REJECT = 'reject';
}
