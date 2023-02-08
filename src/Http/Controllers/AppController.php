<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\UpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\App\AppResource;

class AppController extends Controller
{
    public function __construct(protected IAppManager $appManager)
    {
    }

    public function search(SearchRequest $searchRequest): AppResource
    {
        $search = $this->appManager->search($searchRequest->only(
            [
                'title',
                'owner',
                'user',
            ]
        ));

        return new AppResource($search);
    }

    public function store(StoreRequest $storeRequest): AppResource
    {
        $store = $this->appManager->store(
            $storeRequest->input('title'),
            $storeRequest->input('extra'),
            $storeRequest->input('owner'),
            userActivityLog: true
        );

        return AppResource::make($store);
    }

    public function update(int $id, UpdateRequest $updateRequest): AppResource
    {
        $update = $this->appManager->update($id, $updateRequest->validated(), userActivityLog: true);

        return AppResource::make($update);
    }

    public function destroy(int $id): void
    {
        $this->appManager->destroy($id, userActivityLog: true);
    }
}
