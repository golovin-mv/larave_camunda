<?php

namespace Core\Common\Infrastructure\Camunda;

class CamundaVariable
{
    public function __construct(
        public readonly string $name,
        public readonly CamundaVariableType $type,
        public readonly mixed $value)
    {}
    //TODO from array
}
