<?php

namespace dnj\ErrorTracker\Database\Factories;

use dnj\ErrorTracker\Laravel\Server\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'extra' => serialize(fake()->words(3)),
            'owner' => rand(1, 5),
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }

}
