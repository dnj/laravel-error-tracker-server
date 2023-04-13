<?php

namespace dnj\ErrorTracker\Laravel\Server;

use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use dnj\UserLogger\Contracts\ILogger;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LogManager implements ILogManager
{
    public function __construct(protected ILogger $userLogger)
    {
    }

    /**
     * @return Collection<Log>
     */
    public function search(array $filters): Collection
    {
        return Log::query()->filter($filters)->get();
    }

    public function store(int|IApp $app, IDevice|int $device, LogLevel $level, string $message, ?array $data = null, ?array $read = null): Log
    {
        return DB::transaction(function () use ($app, $device, $level, $message, $data, $read) {
            if ($app instanceof IApp) {
                $app = $app->getId();
            }
            if ($device instanceof IDevice) {
                $device = $device->getId();
            }

            if ($read) {
                if (!isset($read['readAt'])) {
                    $read['readAt'] = now();
                }
                if ($read['user'] instanceof Authenticatable) {
                    $read['user'] = $read['user']->getAuthIdentifier();
                }
            }
            $log = Log::query()->create([
                'app_id' => $app,
                'device_id' => $device,
                'level' => $level,
                'message' => $message,
                'data' => $data,
                'reader_id' => $read ? $read['user'] : null,
                'read_at' => $read ? $read['readAt'] : null,
            ]);

            return $log;
        });
    }

    public function markAsRead(ILog|int $log, int|Authenticatable $user, ?\DateTimeInterface $readAt = null, bool $userActivityLog = false): Log
    {
        return DB::transaction(function () use ($log, $user, $readAt) {
            if ($log instanceof ILog) {
                $log = $log->getId();
            }
            if ($user instanceof Authenticatable) {
                $user = $user->getAuthIdentifier();
            }
            if (!$readAt) {
                $readAt = now();
            }

            /**
             * @var Log
             */
            $log = Log::query()
                ->lockForUpdate()
                ->findOrFail($log);
            $log->update([
                'reader_id' => $user,
                'read_at' => $readAt,
            ]);

            return $log;
        });
    }

    public function markAsUnread(ILog|int $log, bool $userActivityLog = false): ILog
    {
        return DB::transaction(function () use ($log, $userActivityLog) {
            if ($log instanceof ILog) {
                $log = $log->getId();
            }

            /**
             * @var Log
             */
            $log = Log::query()
                ->lockForUpdate()
                ->findOrFail($log)
                ->fill([
                    'reader_id' => null,
                    'read_at' => null,
                ]);
            $changes = $log->changesForLog();
            $log->save();

            if ($userActivityLog) {
                $this->userLogger->on($log)
                    ->withRequest(request())
                    ->withProperties($changes)
                    ->log('mark-as-unread');
            }

            return $log;
        });
    }

    public function destroy(ILog|int $log, bool $userActivityLog = false): void
    {
        DB::transaction(function () use ($log, $userActivityLog) {
            if ($log instanceof ILog) {
                $log = $log->getId();
            }

            /**
             * @var Log
             */
            $log = Log::query()
                ->lockForUpdate()
                ->findOrFail($log);
            $log->delete();

            if ($userActivityLog) {
                $this->userLogger->on($log)
                    ->withRequest(request())
                    ->log('destroyed');
            }
        });
    }
}
