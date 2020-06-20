<?php

namespace Innoflash\EnvUpdater;

use Illuminate\Support\ServiceProvider;
use Innoflash\EnvUpdater\Console\Commands\AddEnvValCommand;
use Innoflash\EnvUpdater\Console\Commands\EnvViewCommand;
use Innoflash\EnvUpdater\Console\Commands\UpdateEnvValCommand;

class EnvUpdaterServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('env-updater.php'),
            ], 'env-updater-config');

            // Registering package commands.
            $this->commands([
                EnvViewCommand::class,
                UpdateEnvValCommand::class,
                AddEnvValCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'env-updater');

        // Register the main class to use with the facade
        $this->app->singleton('env-updater', function () {
            return new EnvUpdater;
        });
    }
}
