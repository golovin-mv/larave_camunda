<?php

namespace Core\Scoring\Infrastructure\Interfaces\Camunda;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Core\Scoring\Application\Commands\StartScoringCommand;

class CoreScoringListener extends CamundaTaskHandler
{
    public function handle(CamundaClient $client, CommandBus $commandBus)
    {
        $client->completeTask(
            $this->task->getId()
        );

        $commandBus->dispatch(new StartScoringCommand(
           $this->task->getBusinessKey(),
           $this->task->getVariables()['firstName']['value'],
           $this->task->getVariables()['summ']['value']
        ));
    }
}
