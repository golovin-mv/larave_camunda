<?php

namespace Core\Common\Infrastructure\Camunda;

// TODO interface
use Illuminate\Support\Collection;

class CamundaTask{
    /**
     * @param string $id
     * @param mixed $businessKey
     * @param string $topicName
     * @param string $workerId
     * @param Collection $variables
     * @param Collection $rawTask
     */
    public function __construct(
        private readonly string $id,
        private readonly mixed $businessKey,
        private readonly string $topicName,
        private readonly string $workerId,
        private readonly Collection $variables,
        private readonly Collection $rawTask
    )
    {}

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getBusinessKey(): mixed
    {
        return $this->businessKey;
    }

    /**
     * @return string
     */
    public function getTopicName(): string
    {
        return $this->topicName;
    }

    /**
     * @return string
     */
    public function getWorkerId(): string
    {
        return $this->workerId;
    }

    /**
     * @return Collection
     */
    public function getVariables(): Collection
    {
        return $this->variables;
    }

    /**
     * @return Collection
     */
    public function getRawTask(): Collection
    {
        return $this->rawTask;
    }

    public static function fromRaw(Collection $rawTask): CamundaTask
    {
        return new CamundaTask(
            $rawTask->get('id'),
            $rawTask->get('businessKey'),
            $rawTask->get('topicName'),
            $rawTask->get('workerId'),
            collect($rawTask->get('variables')),
            $rawTask
        );
    }
}
