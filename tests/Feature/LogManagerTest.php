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

        $response = $this->get(route('log.search',
            [
                'apps' => [$app->id],
                'devices' => [$device->id],
                'level' => LogLevel::INFO->name,
                'message' => 'test',
                'unread' => true,
                // 'user' => '',
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

        $this->postJson(route('log.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_CREATED)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testMarkAsRead()
    {
        $log = Log::factory()->create();

        $data = [
            'userId' => 1,
            'readAt' => Carbon::now(),
            'userActivityLog' => false,
        ];

        $this->putJson(route('log.mark_as_read', ['log' => $log->id]), $data)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testMarkAsUnRead()
    {
        $log = Log::factory()->create();

        $data = [
            'userId' => 1,
            'readAt' => Carbon::now(),
            'userActivityLog' => false,
        ];

        $this->putJson(route('log.mark_as_read', ['log' => $log->id]), $data)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testCanDestroy()
    {
        $app = Log::factory()->create();

        $this->deleteJson(route('log.destroy', ['id' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }
}
