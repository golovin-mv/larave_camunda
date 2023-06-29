<?php

namespace Core\Scoring\Infrastructure\Interfaces\Camunda;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Core\Common\Infrastructure\Camunda\CamundaVariable;
use Core\Common\Infrastructure\Camunda\CamundaVariableType;
use Core\Scoring\Application\Commands\StartPrescoringReviewCommand;
use Illuminate\Support\Facades\Log;

class SendToPrescoringListener extends CamundaTaskHandler
{
    public function handle(CamundaClient $client, CommandBus $bus): void
    {
        $review = $bus->dispatch(new StartPrescoringReviewCommand(
            $this->task->getBusinessKey(),
            $this->task->getVariables()['firstName']['value'],
        ));

        $client->completeTask($this->task->getId(), [
            new CamundaVariable(
                'prescoringResult',
                CamundaVariableType::STRING,
                $review->getResult()->valueOf(),
            )
        ]);
    }
}
