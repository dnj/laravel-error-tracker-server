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
            'owner_id' => rand(1, 10),
            'owner_id_column' => 'owner_id',
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }
}
