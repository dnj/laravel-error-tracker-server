<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use Carbon\Carbon;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogManagerTest extends TestCase
{
    public function testLogSearch()
    {
        $app = App::factory()->create();
        $device = Device::factory()->create();

        $response = $this->get(route('logs.index',
            [
                'apps' => [$app->id],
                'devices' => [$device->id],
                'level' => LogLevel::INFO->name,
                'message' => 'test',
                'unread' => true,
                'user' => 1,
            ]
        ));

        $response->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testCanStore(): void
    {
        $app = App::factory()->create();
        $device = Device::factory()->create();

        $data = [
            'app' => $app->id,
            'device' => $device->id,
            'level' => LogLevel::INFO->name,
            'message' => 'message test',
            'data' => ['test_key edited' => 'test_value edited'],
            'read' => ['userId' => 1, 'readAt' => Carbon::now()],
        ];

        $this->postJson(route('logs.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_CREATED)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        unset($data['app']);

        $data = $this->makeDataForAssert($data);

        $this->assertDatabaseHas('logs', $data);
    }

    public function testMarkAsRead()
    {
        $log = Log::factory()->create();

        $data = [
            'userId' => 1,
            'readAt' => Carbon::now(),
        ];

        $this->putJson(route('logs.mark_as_read', ['log' => $log->id]), $data)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseHas('logs', [
            'read->userId' => $data['userId'],
            'read->readAt' => (string) $data['readAt'],
        ]);
    }

    public function testCanNotMarkAsRead()
    {
        $data = [
            'userId' => 1,
            'readAt' => Carbon::now(),
        ];

        $this->putJson(route('logs.mark_as_read', ['log' => 100]), $data)
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND) // 404
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testMarkAsUnRead()
    {
        $log = Log::factory()->create();

        $this->putJson(route('logs.mark_as_unread', ['log' => $log->id]))
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseHas('logs', [
            'read->userId' => null,
            'read->readAt' => null,
        ]);
    }

    public function testCanNotMarkAsUnRead()
    {
        $this->putJson(route('logs.mark_as_unread', ['log' => 100]))
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND) // 404
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseCount('logs', 0);
    }

    public function testCanDestroy()
    {
        $app = Log::factory()->create();

        $this->deleteJson(route('logs.destroy', ['log' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCanNotDestroy()
    {
        $this->deleteJson(route('logs.destroy', ['log' => 100]))
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND);
    }


    private function makeDataForAssert(array $data): array
    {
        $data['data'] = json_encode($data['data']);
        $data['read'] = json_encode($data['read']);
        $data['device_id'] = $data['device'];
        unset($data['device']);

        return $data;
    }
}
