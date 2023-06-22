<?php

namespace Core\Loans;

use Core\Common\Infrastructure\Camunda\CamundaClient;
use Core\Loans\Infrastructure\Interfaces\Camunda\CheckLead\CheckLeadHandler;
use Core\Loans\Infrastructure\Interfaces\Http\LoanController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class LoanServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {

    }

    public function boot()
    {
        $this->mapRoutes();
    }

    private function mapRoutes()
    {
        Route::prefix('loan')->group(function () {
            Route::post('createLoan', [LoanController::class, 'createLoan']);
        });
    }
}
