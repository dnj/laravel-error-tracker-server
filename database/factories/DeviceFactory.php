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
            'owner_id' => rand(1, 5),
            'owner_id_column' => 'owner_id',
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }
}
