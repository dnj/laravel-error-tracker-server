<?php

namespace dnj\ErrorTracker\Laravel\Database\Factories;

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppFactory extends Factory
{
    protected $model = App::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'meta' => [fake()->words(3)],
            'owner_id' => User::factory(),
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }

    public function withTitle(string $title): static
    {
        return $this->state(fn () => [
            'title' => $title,
        ]);
    }

    /**
     * @param array<string,mixed> $meta
     */
    public function withMeta(array $meta): static
    {
        return $this->state(fn () => [
            'meta' => $meta,
        ]);
    }

    public function withOwner(int $owner): static
    {
        return $this->state(fn () => [
            'owner_id' => $owner,
        ]);
    }
}
