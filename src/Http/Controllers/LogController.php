<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\ILogManager;
use dnj\ErrorTracker\Laravel\Server\Http\Requests\Log\SearchRequest;
use dnj\ErrorTracker\Laravel\Server\Http\Resources\Log\SearchResource;

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

    public function store()
    {

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


}
