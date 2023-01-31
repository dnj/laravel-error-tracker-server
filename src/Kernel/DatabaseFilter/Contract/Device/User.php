<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Device;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class User extends FiltersAbstract
{
    public function handel()
    {
        $this->builder->where('user', '=', $this->attribute);
    }
}
