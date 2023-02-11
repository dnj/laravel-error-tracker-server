<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AppManagerTest extends TestCase
{
    public function testUserCanSearch(): void
    {
        App::factory(2)->create();

        $response = $this->get(route('apps.index', ['title' => 'test', 'owner' => 1, 'user' => 1]));

        $response->assertStatus(ResponseAlias::HTTP_OK); // 200
    }

    public function testUserCanStore(): void
    {
        $data = [
            'title' => 'Test App',
            'extra' => ['test_key' => 'test_value'],
            'owner' => 1,
        ];

        $this->postJson(route('apps.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_CREATED) // 201
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $data = $this->prepareForAssert($data);
        $this->assertDatabaseHas('apps', $data);
        $this->assertDatabaseCount('apps', 1);
    }

    public function testUserCanNotStore(): void
    {
        $data = [
            'title' => '',
            'extra' => [''],
            'owner' => '',
        ];

        $this->postJson(route('apps.store'), $data)
            ->assertStatus(ResponseAlias::HTTP_UNPROCESSABLE_ENTITY) // 422
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseCount('apps', 0);
    }

    public function testCanUpdateApp(): void
    {
        $app = App::factory()->create();

        $changes = [
            'title' => 'Test App edited',
            'extra' => ['test_key' => 'test_value'],
            'owner' => 3,
        ];

        $this->putJson(route('apps.update', ['app' => $app->id]), $changes)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $changes = $this->prepareForAssert($changes);
        $this->assertDatabaseHas('apps', $changes);
        $this->assertDatabaseCount('apps', 1);
    }

    public function testCanNotUpdateApp(): void
    {
        $changes = [];

        $this->putJson(route('apps.update', ['app' => 100]), $changes)
            ->assertStatus(ResponseAlias::HTTP_NOT_FOUND) // 404
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });

        $this->assertDatabaseCount('apps', 0);
    }

    public function testDestroy(): void
    {
        $app = App::factory()->create();

        $this->deleteJson(route('apps.destroy', ['app' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK); // 200
    }

    public function testCanNotDestroy(): void
    {
        $app = App::factory()->create();

        $this->deleteJson(route('apps.destroy', ['app' => 100]))
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
