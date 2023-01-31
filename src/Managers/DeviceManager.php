<?php

namespace dnj\ErrorTracker\Laravel\Server\Managers;

use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Laravel\Server\Models\Device;

class DeviceManager implements IDeviceManager
{
    public function search(array $filters): iterable
    {
        return Device::filter($filters)->get();
    }

    public function store(?string $title = null, ?array $extra = null, ?int $owner = null, bool $userActivityLog = false): IDevice
    {
        $device = new Device(
            [
                'title' => $title,
                'extra' => $extra,
                'owner' => $owner,
            ]
        );

        $device->save();

        return $device;
    }

    public function update(IDevice|int $device, array $changes, bool $userActivityLog = false): IDevice
    {
        $model = Device::query()->findOrFail($device);
        $model->fill($changes);
        $model->save();

        return $model;
    }

    public function destroy(IDevice|int $device, bool $userActivityLog = false): void
    {
        $model = Device::query()->findOrFail($device);
        $model->delete();
    }
}
