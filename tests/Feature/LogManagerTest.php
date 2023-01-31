<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use dnj\ErrorTracker\Laravel\Server\Constants\LogLevelConstants;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class LogManagerTest extends TestCase
{
    public function testLogSearch()
    {
        Log::factory(2)->create();

        $response = $this->get(route('log.search',
            [
                'apps' => [1],
                'devices' => [1],
                'levels' => [LogLevelConstants::INFO],
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

    public function testCanDestroy()
    {
        $app = Log::factory()->create();

        $this->deleteJson(route('device.destroy', ['id' => $app->id]))
            ->assertStatus(ResponseAlias::HTTP_OK);
    }

}
