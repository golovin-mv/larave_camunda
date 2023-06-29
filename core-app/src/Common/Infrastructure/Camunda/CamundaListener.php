<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Support\Facades\Log;

class CamundaListener extends CamundaClient
{

    public function listen(): void
    {
        $tasks = $this->fetchAndLock();

        $tasks->each(function (CamundaTask $task) {
            $this->dispatchTask($task);
        });
    }

    // TODO throw error if handler is empty
    private function dispatchTask(CamundaTask $task)
    {
        $handler = Camunda::getHandlerByTopicName($task->getTopicName());
        $handler::dispatch($task);
    }
}
