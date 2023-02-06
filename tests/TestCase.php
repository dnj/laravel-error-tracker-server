<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests;

use dnj\ErrorTracker\Laravel\Server\ServiceProvider;
use dnj\ErrorTracker\Laravel\Server\Tests\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        // config()->set('error-tracker.user_model', User::class);
    }

    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }

    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
