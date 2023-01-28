<?php

namespace dnj\ErrorTracker\Laravel\Server\Http\Controllers;

use dnj\ErrorTracker\Contracts\IDeviceManager;

class DeviceController extends Controller
{
    public function __construct(protected IDeviceManager $deviceManager)
    {
    }
    // TODO
}
