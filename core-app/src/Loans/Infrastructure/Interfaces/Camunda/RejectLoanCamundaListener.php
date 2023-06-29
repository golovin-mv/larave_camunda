<?php

namespace Core\Loans\Infrastructure\Interfaces\Camunda;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Core\Loans\Application\Commands\RejectLoan\RejectLoanCommand;

class RejectLoanCamundaListener extends CamundaTaskHandler
{
    public function handle(CamundaClient $client, CommandBus $commandBus)
    {
        $commandBus->dispatch(
            new RejectLoanCommand(
                $this->task->getBusinessKey()
            )
        );

        $client->completeTask(
            $this->task->getId()
        );
    }
}
