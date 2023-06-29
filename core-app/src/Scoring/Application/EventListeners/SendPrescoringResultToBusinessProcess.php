<?php

namespace Core\Scoring\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaVariable;
use Core\Common\Infrastructure\Camunda\CamundaVariableType;
use Core\Scoring\Domain\Events\PrescoringReviewRejected;
use Core\Scoring\Domain\Events\PrescoringReviewSuccess;
use Illuminate\Support\Facades\Log;

class SendPrescoringResultToBusinessProcess implements EventListener
{
    public function __construct(
        private readonly CamundaClient $camundaClient,
    )
    {}

    public function __invoke(PrescoringReviewRejected | PrescoringReviewSuccess $event): void
    {
        $this->camundaClient->message(
            'core_prescoring_complete',
            $event->review->getLoanId()->valueOf(),
            [
                new CamundaVariable(
                    'prescoringResult',
                    CamundaVariableType::STRING,
                    $event->review->getResult()->valueOf(),
                )
            ]
        );
    }
}
