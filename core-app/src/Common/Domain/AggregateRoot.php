<?php

namespace Core\Common\Domain;

use Illuminate\Support\Collection;

abstract class AggregateRoot implements PrimitiveMarshaller
{
    private Collection $domainEvents;
    protected function __construct()
    {
        $this->domainEvents = collect();
    }

    final public function applyEvent(DomainEvent $event): void
    {
        $this->domainEvents->push($event);
    }

    final public function pullEvents(): Collection
    {
        $events = $this->domainEvents;

        $this->domainEvents = collect();

        return $events;
    }

}
