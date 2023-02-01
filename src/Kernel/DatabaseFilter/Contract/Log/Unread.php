<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Log;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Unread extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->where('unread', '=', $this->attribute);
    }
}
