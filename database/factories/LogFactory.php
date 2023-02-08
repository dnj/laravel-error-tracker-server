<?php

namespace dnj\ErrorTracker\Database\Factories;

use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        $app = App::factory(1)->create();
        $device = Device::factory(1)->create();

        return [
            'app_id' => $app[0]->id,
            'device_id' => $device[0]->id,
            'level' => LogLevel::INFO,
            'message' => fake()->sentence,
            'data' => json_encode([fake()->words(3)]),
            'read' => json_encode(['userId' => fake()->randomNumber(1, 5), 'readAt' => null]),
        ];
    }
}
