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
        $app = new App(
            [
                'title' => $title,
                'extra' => $extra,
                'owner' => $owner,
                'userActivityLog' => true,
            ]
        );

        $app->save();

        return $app;
    }

    public function update(int|IApp $app, array $changes, bool $userActivityLog = false): IApp
    {
        $model = App::query()->findOrFail($app);
        $model->fill($changes);
        $model->save();

        return $model;
    }

    public function destroy(int|IApp $app, bool $userActivityLog = false): void
    {
        $model = App::query()->findOrFail($app);
        $model->delete();
    }
}
