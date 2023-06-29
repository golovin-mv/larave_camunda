<?php

namespace Core\Loans\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Loans\Domain\Events\LoanAddressAdded;

class SendLoanAddressToBusinessProcess implements EventListener
{
    public function __construct(
        private CamundaClient $camundaClient,
    )
    {}

    public function __invoke(LoanAddressAdded $event)
    {
        $this->camundaClient->message(
            'core_address_added',
            $event->loan->getId()->valueOf(),
        );
    }
}
