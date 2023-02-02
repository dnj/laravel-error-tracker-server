<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\StoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Log\SearchResource;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Log\StoreResource;

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

        return new SearchResource($search);
    }

    public function store(StoreRequest $storeRequest): StoreResource
    {
        $levelValue = $this->getEnumValue($storeRequest);
        $log = $this->logManager->store(
            $storeRequest->input('app'),
            $storeRequest->input('device'),
            $levelValue,
            $storeRequest->input('message'),
            $storeRequest->input('data'),
            $storeRequest->input('read'),
        );

        return StoreResource::make($log);
    }

    public function markAsRead()
    {
    }

    public function markAsUnRead()
    {
    }

    public function destroy(int $id)
    {
        $this->logManager->destroy($id);
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
