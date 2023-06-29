<?php

namespace Core\Loans;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Infrastructure\Camunda\Camunda;
use Core\Loans\Application\Commands\AddAddress\AddAddressCommand;
use Core\Loans\Application\Commands\AddAddress\AddAddressHandler;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommand;
use Core\Loans\Application\Commands\CreateLoan\CreateLoanCommandHandler;
use Core\Loans\Application\Commands\EditPassport\EditPassportCommand;
use Core\Loans\Application\Commands\EditPassport\EditPassportCommandHandler;
use Core\Loans\Application\Commands\FinishLoan\FinishLoanCommand;
use Core\Loans\Application\Commands\FinishLoan\FinishLoanCommandHandler;
use Core\Loans\Application\Commands\GetMoney\GetMoneyCommand;
use Core\Loans\Application\Commands\GetMoney\GetMoneyCommandHandler;
use Core\Loans\Application\Commands\RejectLoan\RejectLoanCommand;
use Core\Loans\Application\Commands\RejectLoan\RejectLoanCommandHandler;
use Core\Loans\Application\EventListeners\SendLoanAddressToBusinessProcess;
use Core\Loans\Application\EventListeners\SendLoanPassportToBusinessProcess;
use Core\Loans\Application\EventListeners\StartLoanBusinessProcess;
use Core\Loans\Domain\Events\LoanAddressAdded;
use Core\Loans\Domain\Events\LoanCreatedEvent;
use Core\Loans\Domain\Events\LoanPassportEdited;
use Core\Loans\Domain\LoanRepository;
use Core\Loans\Infrastructure\Eloquent\Repositories\EloquentLoanRepository;
use Core\Loans\Infrastructure\Interfaces\Camunda\CheckLead\CheckLeadHandler;
use Core\Loans\Infrastructure\Interfaces\Camunda\CoreMoneyListener;
use Core\Loans\Infrastructure\Interfaces\Camunda\FinishLoanHandler;
use Core\Loans\Infrastructure\Interfaces\Camunda\RejectLoanCamundaListener;
use Core\Loans\Infrastructure\Interfaces\Http\LoanController;
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
            Route::post('{id}/editPassport', [LoanController::class, 'editLoanPassport']);
            Route::post('{id}/addAddress', [LoanController::class, 'addAddress']);
            Route::post('{id}/finish', [LoanController::class, 'finish']);
        });
    }

    private function mapCommands(): void
    {
        $bus = $this->app->make(CommandBus::class);
        $bus->map([
            CreateLoanCommand::class => CreateLoanCommandHandler::class,
            EditPassportCommand::class => EditPassportCommandHandler::class,
            AddAddressCommand::class => AddAddressHandler::class,
            FinishLoanCommand::class => FinishLoanCommandHandler::class,
            RejectLoanCommand::class => RejectLoanCommandHandler::class,
            GetMoneyCommand::class => GetMoneyCommandHandler::class,
        ]);
    }

    private function mapCamundaListeners(): void
    {
        Camunda::bind('core_test', CheckLeadHandler::class);
        Camunda::bind('core_finish', FinishLoanHandler::class);
        Camunda::bind('core_reject', RejectLoanCamundaListener::class);
        Camunda::bind('core_money', CoreMoneyListener::class);
    }

    private function mapEvents(): void
    {
        $eventBus = $this->app->make(EventBus::class);
        $eventBus->subscribeTo(LoanCreatedEvent::class, StartLoanBusinessProcess::class);
        $eventBus->subscribeTo(LoanPassportEdited::class, SendLoanPassportToBusinessProcess::class);
        $eventBus->subscribeTo(LoanAddressAdded::class, SendLoanAddressToBusinessProcess::class);
    }
}
