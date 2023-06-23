<?php

namespace Core\Common\Application\Bus\Event;

use Core\Common\Domain\DomainEvent;

interface EventBus
{
    /**
     * @param array $domainEvents<DomainEvent>
     * @return void
     */
    public function publish(array $domainEvents): void;
    public function subscribeTo(string $event, string $listener): void;
}
