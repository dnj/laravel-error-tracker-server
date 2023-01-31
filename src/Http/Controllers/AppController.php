<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\App\UpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\App\SearchResource;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\App\StoreResource;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\App\UpdateResource;

class AppController extends Controller
{
    public function __construct(protected IAppManager $appManager)
    {
    }

    public function search(SearchRequest $searchRequest): SearchResource
    {
        $search = $this->appManager->search($searchRequest->only(
            [
                'title',
                'owner',
                'user',
            ]
        ));

        return new SearchResource($search);
    }

    public function store(StoreRequest $storeRequest): StoreResource
    {
        $store = $this->appManager->store(
            $storeRequest->input('title'),
            $storeRequest->input('extra'),
            $storeRequest->input('owner'),
            $storeRequest->input('userActivityLog'),
        );

        return StoreResource::make($store);
    }

    public function update(int $id, UpdateRequest $updateRequest)
    {
        $update = $this->appManager->update($id, $updateRequest->validated(), true);

        return UpdateResource::make($update);
    }

    public function destroy(int $id): void
    {
        $this->appManager->destroy($id);
    }
}
