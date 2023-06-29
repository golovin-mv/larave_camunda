<?php

namespace Core\Loans\Infrastructure\Interfaces\Camunda;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Core\Common\Infrastructure\Camunda\CamundaVariable;
use Core\Common\Infrastructure\Camunda\CamundaVariableType;
use Core\Loans\Application\Commands\FinishLoan\FinishLoanCommand;

class FinishLoanHandler extends CamundaTaskHandler
{
    public function handle(CamundaClient $client, CommandBus $commandBus): void
    {
        $loan = $commandBus->dispatch(
            new FinishLoanCommand($this->task->getBusinessKey())
        );

        $client->completeTask(
            $this->task->getId(),
            [
                new CamundaVariable(
                    'summ',
                    CamundaVariableType::NUMBER,
                    $loan->getAmount()->valueOf(),
                )
            ]
        );
    }
}
