<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use Carbon\Carbon;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\MarkAsReadRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Log\LogResource;
use dnj\ErrorTracker\Laravel\Server\Models\Log;

class LogController extends Controller
{
    public function __construct(protected ILogManager $logManager)
    {
    }

    public function search(SearchRequest $searchRequest)
    {
        $search = $this->logManager->search($searchRequest->only(
            [
                'apps',
                'devices',
                'levels',
                'message',
                'unread',
                'user',
            ]
        ));

        return new LogResource($search);
    }

    public function store(StoreRequest $storeRequest): LogResource
    {
        $levelValue = $this->getEnumValue($storeRequest);
        $log = $this->logManager->store(
            $storeRequest->input('app'),
            $storeRequest->input('device'),
            $levelValue,
            $storeRequest->input('message'),
            $storeRequest->input('data'),
            $storeRequest->input('read'),
            userActivityLog: true
        );

        return LogResource::make($log);
    }

    public function markAsRead(Log $log, MarkAsReadRequest $markAsReadRequest): LogResource
    {
        $markAsRead = $this->logManager->markAsRead(
            $log,
            $markAsReadRequest->get('userId'),
            Carbon::make($markAsReadRequest->get('readAt')),
            userActivityLog: true);

        return LogResource::make($markAsRead);
    }

    public function markAsUnRead(Log $log): LogResource
    {
        $markAsUnread = $this->logManager->markAsUnread($log, userActivityLog: true);

        return LogResource::make($markAsUnread);
    }

    public function destroy(int $id)
    {
        $this->logManager->destroy($id, userActivityLog: true);
    }

    public function getEnumValue(StoreRequest $storeRequest): ?LogLevel
    {
        $value = null;
        foreach (LogLevel::cases() as $case) {
            if ($case->name == $storeRequest->input('level')) {
                $value = $case;
            }
        }

        return $value;
    }
}
