<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Support\Collection;

/**
 * TODO добавить конфигурацию для топика
 */
class CamundaTaskHandlersManager
{
    private Collection $handlers;
    public function __construct()
    {
        $this->handlers = collect();
    }

    public function bind(string $topicName, string $classPath): void
    {
        $this->handlers->put($topicName, $classPath);
    }

    public function getAllHandlers(): Collection
    {
        return $this->handlers->values();
    }

    public function getAllTopics(): Collection
    {
        return $this->handlers->keys();
    }

    public function getHandlerByTopicName(string $topicName)
    {
        return $this->handlers->get($topicName);
    }
}
