<?php

namespace dnj\ErrorTracker\Laravel\Server\Managers;

use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Laravel\Server\Models\App;

class AppManager implements IAppManager
{
    public function search(array $filters): iterable
    {
        return App::filter($filters)->get();
    }

    public function store(string $title, ?array $extra = null, ?int $owner = null, bool $userActivityLog = false): IApp
    {
        $app = new App();

        $app->setTitle($title);
        $app->setOwnerId($owner);
        $app->setOwnerIdColumn('owner_id');
        $app->setExtra($extra);
        $app->save();

        return $app;
    }

    public function update(int|IApp $app, array $changes, bool $userActivityLog = false): IApp
    {
        /** @var App $model */
        $model = App::query()->findOrFail($app);
        $model->setTitle($changes['title']);
        $model->setOwnerId($changes['owner']);
        $model->setExtra($changes['extra']);
        $model->save();

        return $model;
    }

    public function destroy(int|IApp $app, bool $userActivityLog = false): void
    {
        $model = App::query()->findOrFail($app);
        $model->delete();
    }
}
