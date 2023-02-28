<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use Carbon\Carbon;
use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Contracts\LogLevel;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\LogSearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\LogStoreRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\LogResource;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function __construct(protected ILogManager $logManager)
    {
    }

    public function index(LogSearchRequest $request)
    {
        $logs = Log::query()->filter($request->validated())->cursorPaginate();

        return LogResource::make($logs);
    }

    public function store(LogStoreRequest $request): LogResource
    {
        $data = $request->validated();
        $data['level'] = constant(LogLevel::class . "::" . $data['level']);
        $log = $this->logManager->store(
            $data['app'],
            $data['device'],
            $data['level'],
            $data['message'],
            $data['data'],
            null,
        );

        return LogResource::make($log);
    }

    public function markAsRead(int $log): LogResource
    {
        $log = $this->logManager->markAsRead($log, Auth::getUser(), null, true);

        return LogResource::make($log);
    }

    public function markAsUnread(int $log): LogResource
    {
        $log = $this->logManager->markAsUnread($log, true);

        return LogResource::make($log);
    }

    public function destroy(int $log): void
    {
        $this->logManager->destroy($log, true);
    }
}
