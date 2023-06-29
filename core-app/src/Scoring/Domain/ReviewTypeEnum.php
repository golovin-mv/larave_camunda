<?php

namespace Core\Scoring\Domain;

enum ReviewTypeEnum: string
{
    case PRESCORING = 'prescoring';
    case SCORING = 'scoring';
}
