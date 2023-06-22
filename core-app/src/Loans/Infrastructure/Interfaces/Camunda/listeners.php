<?php


use Core\Common\Infrastructure\Camunda\Camunda;
use Core\Loans\Infrastructure\Interfaces\Camunda\CheckLead\CheckLeadHandler;

Camunda::bind('core_test', CheckLeadHandler::class);
