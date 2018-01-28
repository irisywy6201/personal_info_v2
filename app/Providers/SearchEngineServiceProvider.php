<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Ncucc\John\SearchEngine\SearchEngine;

class SearchEngineServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SearchEngine', function($app)
        {
            return new SearchEngine();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    
    public function provides()
    {
        return ['SearchEngine'];
    }
}
