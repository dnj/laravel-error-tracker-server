<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Log;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Devices extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->whereIn('device_id', $this->attribute);
    }
}
