<?php

namespace Core\Loans\Infrastructure\Interfaces\Camunda;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Core\Loans\Application\Commands\GetMoney\GetMoneyCommand;

class CoreMoneyListener extends CamundaTaskHandler
{
    public function handle(CamundaClient $client, CommandBus $commandBus)
    {
        $commandBus->dispatch(
            new GetMoneyCommand($this->task->getBusinessKey())
        );

        $client->completeTask($this->task->getId());
    }
}
