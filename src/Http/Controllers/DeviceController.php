<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\DeviceSearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\DeviceStoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\DeviceUpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\DeviceResource;
use dnj\ErrorTracker\Laravel\Server\Models\Device;

class DeviceController extends Controller
{
    public function __construct(protected IDeviceManager $deviceManager)
    {
    }

    public function index(DeviceSearchRequest $request): DeviceResource
    {
        $devices = Device::query()->filter($request->validated())->cursorPaginate();

        return DeviceResource::make($devices);
    }

    public function store(DeviceStoreRequest $request): DeviceResource
    {
        $data = $request->validated();
        $device = $this->deviceManager->store($data['title'] ?? null, $data['owner'] ?? null, $data['meta'] ?? null, true);

        return DeviceResource::make($device);
    }

    public function update(int $device, DeviceUpdateRequest $request): DeviceResource
    {
        $changes = $request->validated();
        $device = $this->deviceManager->update($device, $changes, true);

        return DeviceResource::make($device);
    }

    public function destroy(int $device): void
    {
        $this->deviceManager->destroy($device, true);
    }
}
