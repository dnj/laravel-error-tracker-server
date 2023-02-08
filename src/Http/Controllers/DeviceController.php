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

    public function search(SearchRequest $searchRequest): DeviceResource
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
        );

        return DeviceResource::make($store);
    }

    public function update(int $id, UpdateRequest $updateRequest): DeviceResource
    {
        $update = $this->deviceManager->update($id, $updateRequest->validated(), false);

        return DeviceResource::make($update);
    }

    public function destroy(int $id)
    {
        $this->deviceManager->destroy($id);
    }
}
