<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;

class AppManagerTest extends TestCase
{
    public function testSearch(): void
    {
        /**
         * @var App $app1
         * @var App $app2
         * @var App $app3
         */
        $app1 = App::factory()
            ->withTitle("test App 1")
            ->create();

        $app2 = App::factory()
            ->withTitle("test App 2")
            ->create();
    
        $app3 = App::factory()
            ->withTitle("App 3")
            ->create();

        $apps = $this->getAppManager()->search(['title' => 'test']);
        $appIds = array_column(iterator_to_array($apps), 'id');
        $this->assertContains($app1->id, $appIds);
        $this->assertContains($app2->id, $appIds);
        $this->assertNotContains($app3->id, $appIds);

        $apps = $this->getAppManager()->search(['title' => 'test', 'owner' => $app1->owner_id]);
        $appIds = array_column(iterator_to_array($apps), 'id');
        $this->assertContains($app1->id, $appIds);
        $this->assertNotContains($app2->id, $appIds);
        $this->assertNotContains($app3->id, $appIds);
    
        $apps = $this->getAppManager()->search(['title' => 'test', 'owner' => $app1->owner]);
        $appIds = array_column(iterator_to_array($apps), 'id');
        $this->assertContains($app1->id, $appIds);
        $this->assertNotContains($app2->id, $appIds);
        $this->assertNotContains($app3->id, $appIds);
    }

    public function testStore(): void
    {
        $data = [
            'title' => 'Test App',
            'meta' => ['key1' => 'v2'],
            'owner' => User::factory()->create(),
        ];

        $app = $this->getAppManager()->store($data['title'], $data['owner'], $data['meta'], true);
        $this->assertModelExists($app);
        $this->assertSame($data['title'], $app->getTitle());
        $this->assertSame($data['meta'], $app->getMeta());
        $this->assertSame($data['owner']->id, $app->getOwnerUserId());
    }

    public function testUpdate(): void
    {
        $changes = [
            'title' => 'Test App',
            'meta' => ['key1' => 'v2'],
            'owner' => User::factory()->create(),
        ];
        $app = App::factory()->create();
        $app = $this->getAppManager()->update($app, $changes, true);
        $this->assertSame($changes['title'], $app->getTitle());
        $this->assertSame($changes['meta'], $app->getMeta());
        $this->assertSame($changes['owner']->id, $app->getOwnerUserId());
    }

    public function testDestroy(): void
    {
        $app = App::factory()->create();
        $this->getAppManager()->destroy($app, true);
        $this->assertModelMissing($app);
    }

}
