<?php

namespace dnj\ErrorTracker\Database\Factories;

use dnj\ErrorTracker\Laravel\Server\Models\App;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppFactory extends Factory
{
    protected $model = App::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'extra' => serialize(fake()->words(3)),
            'owner' => rand(1, 10),
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }
}
