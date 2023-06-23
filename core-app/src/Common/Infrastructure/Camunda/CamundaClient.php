<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

/**
 * TODO interface
 */
class CamundaClient
{
    private PendingRequest $restClient;
    public function __construct()
    {
        $this->restClient = Http::withOptions([
            'base_uri' => config('services.camunda.endpoint'),
            'auth' => [
                config('services.camunda.user'),
                config('services.camunda.password')
            ],
        ]);
    }
    //TODO collection to class
    public final function completeTask(
        string $taskId,
        Collection $variables=null
    ): void
    {
        $response = $this->restClient->post("/external-task/{$taskId}/complete", [
            'workerId' => config('services.camunda.worker_id'),
            'variables' => $variables,
        ]);
    }
    //TODO add variables
    public final function message(
        string $messageName,
        mixed $businessKey
    )
    {
        $response = $this->restClient->post('/message', [
            'messageName' => $messageName,
            'businessKey' => $businessKey,
        ]);

        return $response;
    }

    // TODO разобраться почему не лочит таски
    protected final function fetchAndLock(): Collection
    {
        $response = $this->restClient->post('/external-task/fetchAndLock', [
            'workerId' => config('services.camunda.worker_id'),
            'usePriority' => true,
            'maxTasks' => config('services.camunda.fetch_max_task'),
            'topics' => $this->getTopicListConfiguration()
        ]);

        return $this->createCamundaTasksFromRestResponse($response);
    }

    private function getTopicListConfiguration()
    {
        return Camunda::getAllTopics()->map(function (string $topicName) {
           return [
               'topicName' => $topicName,
               // TODO в конфигурацию
               'lockDuration' => 1000
           ];
        });
    }

    private function createCamundaTasksFromRestResponse(Response $response)
    {
        return $response->collect()->map(function ($responseTask) {
           return CamundaTask::fromRaw(collect($responseTask));
        });
    }
}
