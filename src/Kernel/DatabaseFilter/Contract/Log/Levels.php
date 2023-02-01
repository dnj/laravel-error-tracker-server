<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Log;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Levels extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->whereIn('level', $this->attribute);
    }
}
