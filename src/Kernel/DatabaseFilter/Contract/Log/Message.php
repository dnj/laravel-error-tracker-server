<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Log;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Message extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->where('message', 'LIKE', '%'.$this->attribute.'%');
    }
}
