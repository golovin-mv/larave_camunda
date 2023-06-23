<?php

namespace Core\Loans\Infrastructure\Interfaces\Camunda\CheckLead;

use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Common\Infrastructure\Camunda\CamundaTaskHandler;
use Illuminate\Support\Facades\Log;

class CheckLeadHandler extends CamundaTaskHandler
{
    public function handle(CamundaClient $client): void
    {
        $client->completeTask($this->task->getId());
    }
}
