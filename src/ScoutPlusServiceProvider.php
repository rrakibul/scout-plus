<?php

namespace Mri\ScoutPlus;

use Illuminate\Support\ServiceProvider;
use Laravel\Scout\Builder;
use Laravel\Scout\EngineManager;
use Laravel\Scout\Engines\MeilisearchEngine;
use Laravel\Scout\Scout;
use Meilisearch\Client as Meilisearch;
use Mri\ScoutPlus\Engines\MeilisearchExtendedEngine;

class ScoutPlusServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(Builder::class, BuilderExtended::class);
        
        resolve(EngineManager::class)->extend('meilisearch', function (){
            return new MeilisearchExtendedEngine(new Meilisearch(
                config('scout.meilisearch.host'),
                config('scout.meilisearch.key'),
                clientAgents: [sprintf('Meilisearch Laravel Scout (v%s)', Scout::VERSION)],
            ));
        });
    }
}
