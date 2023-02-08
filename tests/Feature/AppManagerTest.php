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
        $app = App::factory()->create();

        $data = [
            'title' => 'Test App',
            'extra' => ['test_key' => 'test_value'],
            'owner' => 1,
            'userActivityLog' => true,
        ];

        $this->postJson(route('apps.store'), $data)
            ->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testUpdateApp(): void
    {
        $app = App::factory()->create();

        $changes = [
            'title' => 'Test App edited',
            'extra' => ['test_key edited' => 'test_value edited'],
            'owner' => 3,
            'userActivityLog' => false,
        ];

        $this->putJson(route('apps.update', ['app' => $app->id]), $changes)
            ->assertStatus(ResponseAlias::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->etc();
            });
    }

    public function testDestroy(): void
    {
        $app = App::factory()->create();

        $this->deleteJson(route('apps.destroy', ['app' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }
}
