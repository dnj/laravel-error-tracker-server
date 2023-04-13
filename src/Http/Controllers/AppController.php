<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\AppSearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\AppStoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\AppUpdateRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\AppResource;
use dnj\ErrorTracker\Laravel\Server\Models\App;

class AppController extends Controller
{
    public function __construct(protected IAppManager $appManager)
    {
    }

    public function index(AppSearchRequest $request): AppResource
    {
        $apps = App::query()->filter($request->validated())->cursorPaginate();

        return AppResource::make($apps);
    }

    public function store(AppStoreRequest $request): AppResource
    {
        $data = $request->validated();
        $app = $this->appManager->store($data['title'], $data['owner'], $data['meta'] ?? null, true);

        return AppResource::make($app);
    }

    public function update(int $app, AppUpdateRequest $request): AppResource
    {
        $changes = $request->validated();
        $app = $this->appManager->update($app, $changes, true);

        return AppResource::make($app);
    }

    public function destroy(int $app): void
    {
        $this->appManager->destroy($app, true);
    }
}
