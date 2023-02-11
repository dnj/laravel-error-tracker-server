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

        $response = $this->get(route('devices.index', ['title' => 'test', 'owner' => 1, 'user' => 1]));

        $response->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCanStore(): void
    {
        $data = [
            'title' => 'Test App',
            'extra' => ['test_key edited' => 'test_value edited'],
            'owner' => 1,
        ];

        $this->postJson(route('devices.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_CREATED) // 201
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $data = $this->prepareForAssert($data);
        $this->assertDatabaseHas('devices', $data);
        $this->assertDatabaseCount('devices', 1);
    }

    public function testCanNotStoreDevice(): void
    {
        $data = [
            'title' => 'Test App',
            'extra' => 1,
            'owner' => 1,
        ];

        $this->postJson(route('devices.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY) // 422
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseCount('devices', 0);
    }

    public function testCanUpdateDevice()
    {
        $device = Device::factory()->create();

        $changes = [
            'title' => 'Test Device edited',
            'extra' => ['test_key' => 'test_value'],
            'owner' => 1,
        ];

        $this->putJson(route('devices.update', ['device' => $device->id]), $changes)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $changes = $this->prepareForAssert($changes);
        $this->assertDatabaseHas('devices', $changes);
        $this->assertDatabaseCount('devices', 1);
    }


    public function testCanNotUpdateDevice()
    {
        $changes = ['title' => 'test'];

        $this->putJson(route('devices.update', ['device' => 100]), $changes)
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND) // 404
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseCount('apps', 0);
    }

    public function testCanDestroy()
    {
        $app = Device::factory()->create();

        $this->deleteJson(route('devices.destroy', ['device' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }

    public function testCanNotDestroy()
    {
        $this->deleteJson(route('devices.destroy', ['device' => 100]))
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND); // 404
    }

    public function prepareForAssert(array $changes): array
    {
        $changes['extra'] = json_encode($changes['extra']);
        $changes['owner_id'] = $changes['owner'];
        unset($changes['owner']);

        return $changes;
    }
}
