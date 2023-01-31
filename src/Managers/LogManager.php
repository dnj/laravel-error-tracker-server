<?php

namespace dnj\ErrorTracker\Laravel\Server\Managers;

use dnj\ErrorTracker\Contracts\IApp;
use dnj\ErrorTracker\Contracts\IDevice;
use dnj\ErrorTracker\Contracts\ILog;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;

class LogManager implements ILogManager
{
    // TODO
    public function search(array $filters): iterable
    {
        // TODO: Implement search() method.
    }

    public function store(int|IApp $app, IDevice|int $device, LogLevel $level, string $message, ?array $data = null, ?array $read = null, bool $userActivityLog = false): ILog
    {
        // TODO: Implement store() method.
    }

    public function markAsRead(ILog|int $log, ?int $userId = null, ?\DateTimeInterface $readAt = null, bool $userActivityLog = false): ILog
    {
        // TODO: Implement markAsRead() method.
    }

    public function markAsUnread(ILog|int $log, bool $userActivityLog = false): ILog
    {
        // TODO: Implement markAsUnread() method.
    }

    public function destroy(ILog|int $log, bool $userActivityLog = false): void
    {
        // TODO: Implement destroy() method.
    }
}
