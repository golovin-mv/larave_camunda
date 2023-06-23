<?php

namespace Core\Common\Application\Bus\Command;

interface CommandBus
{
    public function dispatch(Command $command): void;
    public function map(array $map): void;
}
