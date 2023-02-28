<?php

namespace dnj\ErrorTracker\Laravel\Server;

use dnj\AAA\Contracts\IUser;
use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IAppManager;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AppManager implements IAppManager
{
    public function __construct(protected ILogger $userLogger)
    {
    }

    /**
     * @return Collection<App>
     */
    public function search(array $filters): Collection
    {
        return App::query()->filter($filters)->get();
    }

    public function store(string $title, int|Authenticatable $owner, ?array $meta = null, bool $userActivityLog = false): App
    {
        return DB::transaction(function () use ($title, $owner, $meta, $userActivityLog) {
            if ($owner instanceof Authenticatable) {
                $owner = $owner->getAuthIdentifier();
            }
            $app = App::query()->create([
                'title' => $title,
                'owner_id' => $owner,
                'meta' => $meta,
            ]);

            if ($userActivityLog) {
                $this->userLogger->on($app)
                    ->withRequest(request())
                    ->withProperties($app->toArray())
                    ->log('created');
            }

            return $app;
        });
    }

    public function update(int|IApp $app, array $changes, bool $userActivityLog = false): App
    {
        return DB::transaction(function () use ($app, $changes, $userActivityLog) {
            if ($app instanceof IApp) {
                $app = $app->getId();
            }

            /**
             * @var App
             */
            $app = App::query()
                ->lockForUpdate()
                ->findOrFail($app);
            if (isset($changes['owner'])) {
                if ($changes['owner'] instanceof Authenticatable) {
                    $changes['owner'] = $changes['owner']->getAuthIdentifier();
                }
                $changes['owner_id'] = $changes['owner'];
                unset($changes['owner']);
            }
            $app->fill($changes);
            $changes = $app->changesForLog();
            $app->save();

            if ($userActivityLog) {
                $this->userLogger->on($app)
                    ->withRequest(request())
                    ->withProperties($changes)
                    ->log('updated');
            }

            return $app;
        });
    }

    public function destroy(int|IApp $app, bool $userActivityLog = false): void
    {
        DB::transaction(function () use ($app, $userActivityLog) {
            if ($app instanceof IApp) {
                $app = $app->getId();
            }

            /**
             * @var App
             */
            $app = App::query()
                ->lockForUpdate()
                ->findOrFail($app);
            $app->delete();

            if ($userActivityLog) {
                $this->userLogger->on($app)
                    ->withRequest(request())
                    ->withProperties($app->toArray())
                    ->log('destroyed');
            }
        });
    }
}
