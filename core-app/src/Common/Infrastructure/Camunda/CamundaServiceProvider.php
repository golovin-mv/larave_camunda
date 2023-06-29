<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Support\ServiceProvider;

class CamundaServiceProvider extends ServiceProvider
{
    protected array $commands = [
        GetCamundaTaskCommand::class,
    ];

    public function register()
    {
        $this->app->bind('camunda', function () {
            return new CamundaTaskHandlersManager();
        });

        $this->commands($this->commands);
    }
}
