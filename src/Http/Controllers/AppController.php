<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IAppManager;

class AppController extends Controller
{
    public function __construct(protected IAppManager $appManager)
    {
    }
    // TODO
}
