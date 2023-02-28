<?php

namespace dnj\ErrorTracker\Laravel\Server;

use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class DeviceManager implements IDeviceManager
{
    public function __construct(protected ILogger $userLogger)
    {
    }

    /**
     * @return Collection<Device>
     */
    public function search(array $filters): Collection
    {
        return Device::query()->filter($filters)->get();
    }

    public function store(?string $title = null, int|Authenticatable|null $owner = null, ?array $meta = null, bool $userActivityLog = false): Device
    {
        return DB::transaction(function () use ($title, $owner, $meta, $userActivityLog) {
            if ($owner instanceof Authenticatable) {
                $owner = $owner->getAuthIdentifier();
            }
            $device = Device::query()->create([
                'title' => $title,
                'owner_id' => $owner,
                'meta' => $meta,
            ]);

            if ($userActivityLog) {
                $this->userLogger->on($device)
                    ->withRequest(request())
                    ->withProperties($device->toArray())
                    ->log('created');
            }

            return $device;
        });
    }

    public function update(int|IDevice $device, array $changes, bool $userActivityLog = false): Device
    {
        return DB::transaction(function () use ($device, $changes, $userActivityLog) {
            if ($device instanceof IDevice) {
                $device = $device->getId();
            }

            /**
             * @var Device
             */
            $device = Device::query()
                ->lockForUpdate()
                ->findOrFail($device);
            if (array_key_exists('owner', $changes)) {
                if ($changes['owner'] instanceof Authenticatable) {
                    $changes['owner'] = $changes['owner']->getAuthIdentifier();
                }
                $changes['owner_id'] = $changes['owner'];
                unset($changes['owner']);
            }
            $device->fill($changes);
            $changes = $device->changesForLog();
            $device->save();

            if ($userActivityLog) {
                $this->userLogger->on($device)
                    ->withRequest(request())
                    ->withProperties($changes)
                    ->log('updated');
            }

            return $device;
        });
    }

    public function destroy(int|IDevice $device, bool $userActivityLog = false): void
    {
        DB::transaction(function () use ($device, $userActivityLog) {
            if ($device instanceof IDevice) {
                $device = $device->getId();
            }

            /**
             * @var Device
             */
            $device = Device::query()
                ->lockForUpdate()
                ->findOrFail($device);
            $device->delete();

            if ($userActivityLog) {
                $this->userLogger->on($device)
                    ->withRequest(request())
                    ->withProperties($device->toArray())
                    ->log('destroyed');
            }
        });
    }
}
