<?php

namespace App\Providers;

use App\Observers\StoryObserver;
use App\Observers\UniverseObserver;
use App\Story;
use App\Universe;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Universe::observe(UniverseObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);

            /* \DB::listen(function($query) {
                \Log::debug(
                    $query->sql,
                    $query->bindings,
                    $query->time
                );
            }); */
        }

        //
    }
}
