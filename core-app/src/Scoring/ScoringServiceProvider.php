<?php

namespace Core\Scoring;

use Core\Common\Application\Bus\Command\CommandBus;
use Core\Common\Application\Bus\Event\EventBus;
use Core\Common\Infrastructure\Camunda\Camunda;
use Core\Scoring\Application\Commands\StartPrescoringReviewCommand;
use Core\Scoring\Application\Commands\StartPrescoringReviewHandler;
use Core\Scoring\Application\Commands\StartScoringCommand;
use Core\Scoring\Application\Commands\StartScoringCommandHandler;
use Core\Scoring\Application\EventListeners\SendPrescoringResultToBusinessProcess;
use Core\Scoring\Application\EventListeners\SendScoringResultToBusinessProcess;
use Core\Scoring\Domain\Events\PrescoringReviewRejected;
use Core\Scoring\Domain\Events\PrescoringReviewSuccess;
use Core\Scoring\Domain\Events\ScoringSuccess;
use Core\Scoring\Domain\ReviewRepository;
use Core\Scoring\Infrastructure\Eloquent\Repositories\FakeReviewRepository;
use Core\Scoring\Infrastructure\Interfaces\Camunda\CoreScoringListener;
use Core\Scoring\Infrastructure\Interfaces\Camunda\SendToPrescoringListener;
use Illuminate\Support\ServiceProvider;

class ScoringServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ReviewRepository::class, FakeReviewRepository::class);
    }

    public function boot()
    {
        $this->mapCamunda();
        $this->mapCommand();
        $this->mapEvents();
    }

    private function mapCamunda(): void
    {
        Camunda::bind('core_prescoring', SendToPrescoringListener::class);
        Camunda::bind('core_scoring', CoreScoringListener::class);
    }

    private function mapCommand()
    {
         $bus = $this->app->make(CommandBus::class);
         $bus->map([
             StartPrescoringReviewCommand::class => StartPrescoringReviewHandler::class,
             StartScoringCommand::class => StartScoringCommandHandler::class,
         ]);
    }

    private function mapEvents()
    {
        $eventBus = $this->app->make(EventBus::class);
        $eventBus->subscribeTo(PrescoringReviewSuccess::class, SendPrescoringResultToBusinessProcess::class);
        $eventBus->subscribeTo(PrescoringReviewRejected::class, SendPrescoringResultToBusinessProcess::class);
        $eventBus->subscribeTo(ScoringSuccess::class, SendScoringResultToBusinessProcess::class);
    }
}
