<?php

namespace Core\Common\Infrastructure\Bus;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Infrastructure\Bus\Command\IlluminateCommandBus;
use Core\Common\Infrastructure\Bus\Event\IlluminateEventBus;
use Illuminate\Support\ServiceProvider;
use League\Event\EventDispatcher;

class BusServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CommandBus::class, IlluminateCommandBus::class);
        $this->app->singleton(EventDispatcher::class, function (){
            return new EventDispatcher();
        });
        $this->app->singleton(EventBus::class, function ()
        {
            return new IlluminateEventBus($this->app->make(EventDispatcher::class));
        });
    }

}
