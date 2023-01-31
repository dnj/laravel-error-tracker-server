<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IDeviceManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Device\UpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Device\SearchResource;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Device\StoreResource;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Device\UpdateResource;

class DeviceController extends Controller
{
    public function __construct(protected IDeviceManager $deviceManager)
    {
    }

    /**
     * @param SearchRequest $searchRequest
     * @return SearchResource
     */
    public function search(SearchRequest $searchRequest): SearchResource
    {
        $search = $this->deviceManager->search($searchRequest->only(
            [
                'title',
                'user',
                'owner',
            ]
        ));

        return new SearchResource($search);
    }

    public function store(StoreRequest $storeRequest): StoreResource
    {
        $store = $this->deviceManager->store(
            $storeRequest->input('title'),
            $storeRequest->input('extra'),
            $storeRequest->input('owner'),
        );

        return StoreResource::make($store);
    }

    public function update(int $id, UpdateRequest $updateRequest): UpdateResource
    {
        $update = $this->deviceManager->update($id, $updateRequest->validated(), false);

        return UpdateResource::make($update);
    }

    public function destroy(int $id)
    {
        $this->deviceManager->destroy($id);
    }

}
