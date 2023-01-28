<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\ILogManager;

class LogController extends Controller
{
    public function __construct(protected ILogManager $logManager)
    {
    }
    // TODO
}
