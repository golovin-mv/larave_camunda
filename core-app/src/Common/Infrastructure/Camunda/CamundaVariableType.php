<?php

namespace Core\Common\Infrastructure\Camunda;

enum CamundaVariableType: string
{
    case STRING = 'String';
    case NUMBER = 'Number';
    case BOOLEAN = 'Boolean';
    case ARRAY = 'Array';
    case OBJECT = 'Object';
    case NULL = 'Null';
}
