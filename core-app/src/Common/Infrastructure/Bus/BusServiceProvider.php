<?php

namespace Core\Common\Infrastructure\Bus;

use Core\Common\Application\Bus\CommandBus;
use Illuminate\Support\ServiceProvider;

class BusServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
    }

}
