<?php

namespace Core\Scoring\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Scoring\Domain\Events\ScoringSuccess;
use Illuminate\Support\Facades\Log;

class SendScoringResultToBusinessProcess implements EventListener
{
    public function __construct(
        private readonly CamundaClient $camundaClient
    )
    {}

    public function __invoke(ScoringSuccess $event): void
    {
        Log::channel('develop')->info('send message');
        $this->camundaClient->message('core_scoring_ended', $event->review->getLoanId()->valueOf());
    }
}
