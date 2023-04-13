<?php

namespace dnj\ErrorTracker\Laravel\Database\Factories;

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition(): array
    {
        return [
            'app_id' => App::factory(),
            'device_id' => Device::factory(),
            'reader_id' => null,
            'read_at' => null,
            'level' => fake()->randomElement(LogLevel::cases()),
            'message' => fake()->text(),
            'data' => null,
            'created_at' => fake()->dateTime(),
        ];
    }

    /**
     * @param array<string,mixed> $data
     */
    public function withData(array $data): static
    {
        return $this->state(fn () => [
            'data' => $data,
        ]);
    }

    public function withApp(int|App $app): static
    {
        return $this->state(fn () => [
            'app_id' => $app,
        ]);
    }

    public function withDevice(int|Device $device): static
    {
        return $this->state(fn () => [
            'device_id' => $device,
        ]);
    }

    public function read(int|Model|Factory|null $reader = null, ?int $time = null): static
    {
        return $this->state(fn () => [
            'reader_id' => $reader ?? User::factory(),
            'read_at' => fake()->dateTime(),
        ]);
    }

    public function withLevel(LogLevel $level): static
    {
        return $this->state(fn () => [
            'level' => $level,
        ]);
    }

    public function withMessage(string $message): static
    {
        return $this->state(fn () => [
            'message' => $message,
        ]);
    }
}
