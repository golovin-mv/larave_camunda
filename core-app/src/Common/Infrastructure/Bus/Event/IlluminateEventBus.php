<?php

namespace Core\Common\Infrastructure\Bus\Event;

use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Application\Bus\Event\EventDispatcher;
use Core\Common\Application\Bus\Event\EventListener;
use Core\Common\Domain\DomainEvent;

class IlluminateEventBus implements EventBus
{
    public function __construct(
        private $dispatcher
    )
    {}

    public function publish(array $domainEvents): void
    {
        if(is_array($domainEvents) && count($domainEvents) > 0)
        {
            foreach ($domainEvents as $index => $domainEvent) {
                $this->dispatcher->dispatch($domainEvent);
            }
        }
    }

    public function subscribeTo(string $event, string $listener): void
    {
        $this->dispatcher->subscribeTo($event, app()->make($listener));
    }

}
