<?php

namespace Core\Loans;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Infrastructure\Camunda\Camunda;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommand;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommandHandler;
use Core\Loans\Application\EventListeners\StartLoanBusinessProcess;
use Core\Loans\Domain\Events\LoanCreatedEvent;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Infrastructure\Eloquent\Repositories\EloquentLoanRepository;
use Core\Loans\Infrastructure\Interfaces\Camunda\CheckLead\CheckLeadHandler;
use Core\Loans\Infrastructure\Interfaces\Http\LoanController;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LoanServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LoanRepository::class, EloquentLoanRepository::class);
    }

    public function boot(): void
    {
        $this->mapRoutes();
        $this->mapCommands();
        $this->mapCamundaListeners();
        $this->mapEvents();
    }

    private function mapRoutes(): void
    {
        Route::prefix('loan')->group(function () {
            Route::post('createLoan', [LoanController::class, 'createLoan']);
        });
    }

    private function mapCommands(): void
    {
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            CreateLoanCommand::class => CreateLoanCommandHandler::class,
        ]);
    }

    private function mapCamundaListeners(): void
    {
        Camunda::bind('core_test', CheckLeadHandler::class);
    }

    private function mapEvents()
    {
        $eventBus = $this->app->make(EventBus::class);
        $eventBus->subscribeTo(LoanCreatedEvent::class, StartLoanBusinessProcess::class);
    }
}
