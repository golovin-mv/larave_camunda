<?php

namespace Core\Loans\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Loans\Domain\Events\LoanPassportEdited;

class SendLoanPassportToBusinessProcess implements EventListener
{
    public function __construct(
        private CamundaClient $camundaClient,
    )
    {}

    public function __invoke(LoanPassportEdited $event)
    {
        $this->camundaClient->message(
            'core_passport_added',
            $event->loan->getId()->valueOf(),
        );
    }
}
