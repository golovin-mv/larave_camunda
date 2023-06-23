<?php

namespace Core\Loans\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Loans\Domain\Events\LoanCreatedEvent;
use Illuminate\Support\Facades\Log;

class StartLoanBusinessProcess implements EventListener
{
    public function __construct(
        private CamundaClient $client,
    )
    {}

    public function __invoke(LoanCreatedEvent $event)
    {
        $this->client->message('core_lead_created', $event->loan->getId()->valueOf());
    }
}
