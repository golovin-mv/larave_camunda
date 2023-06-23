<?php

namespace Core\Common\Infrastructure\Bus\Command;

use Core\Common\Application\Bus\Command\Command;
use Core\Common\Application\Bus\Command\CommandBus;
use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    public function __construct(private Dispatcher $bus) {}

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }

    /**
     * @param array<Command> $map
     * @return void
     */
    public function map(array $map): void
    {
        $this->bus->map($map);
    }
}
