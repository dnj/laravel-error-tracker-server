<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class DeviceManagerTest extends TestCase
{
    public function testUserCanSearch(): void
    {
        Device::factory(2)->create();

        $response = $this->get(route('device.search', ['title' => 'test', 'owner' => 1, 'user' => 1]));

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCanNotStore(): void
    {
        $data = [
            'title' => 'Test App',
            'extra' => 1,
            'owner' => 1,
            'userActivityLog' => false,
        ];

        $this->postJson(route('device.store'), $data)
            ->assertStatus(422)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testCanStore(): void
    {
        $data = [
            'title' => 'Test App',
            'extra' => ['test_key edited' => 'test_value edited'],
            'owner_id' => 1,
            'owner_id_column' => 1,
        ];

        $this->postJson(route('device.store'), $data)
            ->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testCanUpdate()
    {
        $app = Device::factory()->create();

        $changes = [
            'title' => 'Test App edited',
            'extra' => ['test_key edited' => 'test_value edited'],
            'owner' => 3,
            'userActivityLog' => false,
        ];

        $this->putJson(route('device.update', ['id' => $app->id]), $changes)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testCanDestroy()
    {
        $app = Device::factory()->create();

        $this->deleteJson(route('device.destroy', ['id' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }
}
