<?php

namespace dnj\ErrorTracker\Laravel\Server\Tests\Feature;

use dnj\AAA\Models\User;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Tests\TestCase;

class DeviceManagerTest extends TestCase
{
    public function testSearch(): void
    {
        /**
         * @var Device $device1
         * @var Device $device2
         * @var Device $device3
         */
        $device1 = Device::factory()
            ->withTitle("test Device 1")
            ->create();

        $device2 = Device::factory()
            ->withTitle("test Device 2")
            ->create();

        $device3 = Device::factory()
            ->withTitle("Device 3")
            ->create();

        $devices = $this->getDeviceManager()->search(['title' => 'test']);
        $deviceIds = array_column(iterator_to_array($devices), 'id');
        $this->assertContains($device1->id, $deviceIds);
        $this->assertContains($device2->id, $deviceIds);
        $this->assertNotContains($device3->id, $deviceIds);

        $devices = $this->getDeviceManager()->search(['title' => 'test', 'owner' => $device1->owner_id]);
        $deviceIds = array_column(iterator_to_array($devices), 'id');
        $this->assertContains($device1->id, $deviceIds);
        $this->assertNotContains($device2->id, $deviceIds);
        $this->assertNotContains($device3->id, $deviceIds);

        $devices = $this->getDeviceManager()->search(['title' => 'test', 'owner' => $device1->owner]);
        $deviceIds = array_column(iterator_to_array($devices), 'id');
        $this->assertContains($device1->id, $deviceIds);
        $this->assertNotContains($device2->id, $deviceIds);
        $this->assertNotContains($device3->id, $deviceIds);
    }

    public function testStore(): void
    {
        $data = [
            'title' => 'Test Device',
            'meta' => ['key1' => 'v2'],
            'owner' => User::factory()->create(),
        ];

        $device = $this->getDeviceManager()->store($data['title'], $data['owner'], $data['meta'], true);
        $this->assertModelExists($device);
        $this->assertSame($data['title'], $device->getTitle());
        $this->assertSame($data['meta'], $device->getMeta());
        $this->assertSame($data['owner']->id, $device->getOwnerUserId());
    }

    public function testUpdate(): void
    {
        $changes = [
            'title' => 'Test Device',
            'meta' => ['key1' => 'v2'],
            'owner' => User::factory()->create(),
        ];
        $device = Device::factory()->create();
        $device = $this->getDeviceManager()->update($device, $changes, true);
        $this->assertSame($changes['title'], $device->getTitle());
        $this->assertSame($changes['meta'], $device->getMeta());
        $this->assertSame($changes['owner']->id, $device->getOwnerUserId());
    }

    public function testDestroy(): void
    {
        $device = Device::factory()->create();
        $this->getDeviceManager()->destroy($device, true);
        $this->assertModelMissing($device);
    }
}
