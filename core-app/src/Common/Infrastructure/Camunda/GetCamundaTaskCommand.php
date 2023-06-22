<?php

namespace Core\Common\Infrastructure\Camunda;

use Illuminate\Console\Command;

class GetCamundaTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'camunda:get-camunda-task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get camunda tasks';

    /**
     * Execute the console command.
     */
    public function handle(CamundaListener $listener)
    {
        $listener->listen();
    }
}
