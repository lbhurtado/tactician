<?php

namespace LBHurtado\Tactician;

use Illuminate\Support\ServiceProvider;

class TacticianServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('tactician.php'),
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'tactician');

        $this->app->singleton('tactician', function () {
            return new Tactician;
        });
    }
}
