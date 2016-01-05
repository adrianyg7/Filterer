<?php

namespace Adrianyg7\Filterer;

use Illuminate\Support\ServiceProvider;
use Adrianyg7\Filterer\Contracts\BuildsWhenResolved;

class FiltererServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Adrianyg7\Filterer\Console\Commands\FiltererMakeCommand');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->afterResolving(function(BuildsWhenResolved $resolved) {
            $resolved->build();
        });
    }
}
