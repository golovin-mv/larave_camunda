<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bind(string $topicName, string $classPath): void
 * @method static getAllHandlers(): \Illuminate\Support\Collection
 * @method static getAllTopics(): \Illuminate\Support\Collection
 * @method static getHandlerByTopicName(string $topicName): string
 */
class Camunda extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'camunda';
    }
}
