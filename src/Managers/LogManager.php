<?php

namespace dnj\ErrorTracker\Laravel\Server\Managers;

use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Models\Log;

class LogManager implements ILogManager
{
    public function search(array $filters): iterable
    {
        return Log::filter($filters)->get();
    }

    public function store(int|IApp $app, IDevice|int $device, LogLevel $level, string $message, ?array $data = null, ?array $read = null, bool $userActivityLog = false): ILog
    {
        $model = new Log();

        $model->setRead($read);
        $model->setAppId($app);
        $model->setLevel($level);
        $model->setMessage($message);
        $model->setDeviceId($device);
        $model->setData($data);

        $model->save();

        return $model;
    }

    public function markAsRead(ILog|int $log, ?int $userId = null, ?\DateTimeInterface $readAt = null, bool $userActivityLog = false): ILog
    {
        $readArray = (array) json_decode($log->getRead());

        $readArray['readAt'] = (string) $readAt;
        $readArray['userId'] = $userId;
        $log->setRead($readArray);
        $log->save();

        return $log;
    }

    public function markAsUnread(ILog|int $log, bool $userActivityLog = false): ILog
    {
        $readArray = (array) json_decode($log->getRead());

        $readArray['readAt'] = null;
        $readArray['userId'] = null;
        $log->setRead($readArray);
        $log->save();

        return $log;
    }

    public function destroy(ILog|int $log, bool $userActivityLog = false): void
    {
        $model = Log::query()->findOrFail($log);
        $model->delete();
    }
}
