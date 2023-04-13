<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Fature;

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;

class LogManagerTest extends TestCase
{
    public function testSearch()
    {
        $app = App::factory()->create();
        $device = Device::factory()->create();
        $log1 = Log::factory()->withLevel(LogLevel::ERROR)->withApp($app)->create();
        $log2 = Log::factory()->withLevel(LogLevel::INFO)->withDevice($device)->read()->create();
        $log3 = Log::factory()->withLevel(LogLevel::DEBUG)->withMessage('non critical error')->create();

        $logs = $this->getLogManager()->search([
            'apps' => [$app->id],
        ]);
        $this->assertTrue($logs->contains($log1));
        $this->assertFalse($logs->contains($log2));
        $this->assertFalse($logs->contains($log3));

        $logs = $this->getLogManager()->search([
            'devices' => [$device->id],
        ]);
        $this->assertFalse($logs->contains($log1));
        $this->assertTrue($logs->contains($log2));
        $this->assertFalse($logs->contains($log3));

        $logs = $this->getLogManager()->search([
            'levels' => [LogLevel::DEBUG, LogLevel::ERROR],
        ]);
        $this->assertTrue($logs->contains($log1));
        $this->assertFalse($logs->contains($log2));
        $this->assertTrue($logs->contains($log3));

        $logs = $this->getLogManager()->search([
            'message' => 'critical',
        ]);
        $this->assertFalse($logs->contains($log1));
        $this->assertFalse($logs->contains($log2));
        $this->assertTrue($logs->contains($log3));

        $logs = $this->getLogManager()->search([
            'unread' => false,
        ]);
        $this->assertFalse($logs->contains($log1));
        $this->assertTrue($logs->contains($log2));
        $this->assertFalse($logs->contains($log3));

        $logs = $this->getLogManager()->search([
            'unread' => true,
        ]);
        $this->assertTrue($logs->contains($log1));
        $this->assertFalse($logs->contains($log2));
        $this->assertTrue($logs->contains($log3));
    }

    public function testStore(): void
    {
        $app = App::factory()->create();
        $device = Device::factory()->create();

        $data = [
            'app' => $app,
            'device' => $device,
            'level' => LogLevel::INFO,
            'message' => 'message test',
            'data' => ['test_key' => ['test' => 1]],
            'read' => ['user' => User::factory()->create()],
        ];
        $log = $this->getLogManager()->store($data['app'], $data['device'], $data['level'], $data['message'], $data['data'], $data['read']);
        $this->assertSame($app->id, $log->getAppId());
        $this->assertSame($device->id, $log->getDeviceId());
        $this->assertSame($data['level'], $log->getLevel());
        $this->assertSame($data['message'], $log->getMessage());
        $this->assertSame($data['data'], $log->getData());
        $this->assertSame($data['read']['user']->id, $log->getReaderUserId());
    }

    public function testMarkAsRead(): void
    {
        $log = Log::factory()->create();
        $reader = User::factory()->create();
        $log = $this->getLogManager()->markAsRead($log, $reader);
        $this->assertSame($reader->id, $log->getReaderUserId());
    }

    public function testMarkAsUnread(): void
    {
        $log = Log::factory()->read()->create();
        $log = $this->getLogManager()->markAsUnread($log, true);
        $this->assertNull($log->getReaderUserId());
    }

    public function testDestroy(): void
    {
        $log = Log::factory()->create();
        $this->getLogManager()->destroy($log, true);
        $this->assertModelMissing($log);
    }
}
