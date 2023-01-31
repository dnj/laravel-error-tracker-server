<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Device;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Title extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->where('title', 'LIKE', '%'.$this->attribute.'%');
    }
}

