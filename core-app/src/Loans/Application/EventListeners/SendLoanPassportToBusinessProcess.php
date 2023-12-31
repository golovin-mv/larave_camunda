<?php

namespace Core\Loans\Application\EventListeners;

use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaVariable;
use Core\Common\Infrastructure\Camunda\CamundaVariableType;
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
            [
                new CamundaVariable(
                    'firstName',
                    CamundaVariableType::STRING,
                    $event->loan->getName()->getFirstName(),
                )
            ]
        );
    }
}
