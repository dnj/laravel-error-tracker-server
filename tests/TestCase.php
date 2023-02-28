<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests;

use dnj\ErrorTracker\Laravel\Server\ServiceProvider;
use dnj\AAA\ServiceProvider as AAAServiceProvider;
use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Laravel\Server\AppManager;
use dnj\ErrorTracker\Laravel\Server\DeviceManager;
use dnj\ErrorTracker\Laravel\Server\LogManager;
use dnj\UserLogger\ServiceProvider as UserLoggerServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            UserLoggerServiceProvider::class,
            AAAServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    public function getAppManager(): AppManager {
        return $this->app->make(IAppManager::class);
    }

    public function getDeviceManager(): DeviceManager {
        return $this->app->make(IDeviceManager::class);
    }

    public function getLogManager(): LogManager {
        return $this->app->make(ILogManager::class);
    }
}
