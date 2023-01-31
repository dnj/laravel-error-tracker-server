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
            'extra' => [],
            'owner_id' => null,
            'owner_id_column' => null,
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }

    public function withOwnerId(int $ownerId)
    {
        return $this->state(fn () => [
            'owner_id' => $ownerId,
        ]);
    }
}
