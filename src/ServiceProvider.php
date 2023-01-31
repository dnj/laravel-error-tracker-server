<?php

namespace dnj\ErrorTracker\Laravel\Server;

use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Laravel\Server\Managers\AppManager;
use dnj\ErrorTracker\Laravel\Server\Managers\DeviceManager;
use dnj\ErrorTracker\Laravel\Server\Managers\LogManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/error-tracker.php', 'error-tracker');
        $this->app->singleton(IAppManager::class, AppManager::class);
        $this->app->singleton(IDeviceManager::class, DeviceManager::class);
        $this->app->singleton(ILogManager::class, LogManager::class);
        // TODO
    }

    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/error-tracker.php' => config_path('error-tracker.php'),
            ], 'config');
        }

        // TODO
    }

    protected function loadRoutes()
    {
        if (config('error-tracker.routes.enable')) {
            Route::prefix(config('error-tracker.routes.prefix'))->group(function () {
                $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
            });
        }
    }
}
