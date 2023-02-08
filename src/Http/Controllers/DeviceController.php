<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\UpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Device\DeviceResource;

class DeviceController extends Controller
{
    public function __construct(protected IDeviceManager $deviceManager)
    {
    }

    public function index(SearchRequest $searchRequest): DeviceResource
    {
        $search = $this->deviceManager->search($searchRequest->only(
            [
                'title',
                'user',
                'owner',
            ]
        ));

        return new DeviceResource($search);
    }

    public function store(StoreRequest $storeRequest): DeviceResource
    {
        $store = $this->deviceManager->store(
            $storeRequest->input('title'),
            $storeRequest->input('extra'),
            $storeRequest->input('owner'),
            userActivityLog: true,
        );

        return DeviceResource::make($store);
    }

    public function update(int $device, UpdateRequest $updateRequest): DeviceResource
    {
        $update = $this->deviceManager->update($device, $updateRequest->validated(), userActivityLog: true);

        return DeviceResource::make($update);
    }

    public function destroy(int $device)
    {
        $this->deviceManager->destroy($device, userActivityLog: true);
    }
}
