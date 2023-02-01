<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Device;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Owner extends FiltersAbstract
{
    public function handel(): void
    {
        $this->builder->where('owner', '=', $this->attribute);
    }
}
