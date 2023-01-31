<?php

namespace dnj\ErrorTracker\Laravel\Server\Managers;

use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\IDeviceManager;

class DeviceManager implements IDeviceManager
{
    // TODO
    public function search(array $filters): iterable
    {
        // TODO: Implement search() method.
    }

    public function store(?string $title = null, ?array $extra = null, ?int $owner = null, bool $userActivityLog = false): IDevice
    {
        // TODO: Implement store() method.
    }

    public function update(IDevice|int $device, array $changes, bool $userActivityLog = false): IDevice
    {
        // TODO: Implement update() method.
    }

    public function destroy(IDevice|int $device, bool $userActivityLog = false): void
    {
        // TODO: Implement destroy() method.
    }
}
