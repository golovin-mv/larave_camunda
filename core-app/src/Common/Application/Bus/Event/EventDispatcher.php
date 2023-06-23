<?php

namespace Core\Common\Application\Bus\Event;

use Core\Common\Domain\DomainEvent;

interface EventDispatcher
{
    public function dispatch(DomainEvent $event);
    public function subscribeTo(DomainEvent $event, EventListener $listener);
}
