<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Log;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Apps extends FiltersAbstract
{
    public function handel(): void
    {
        $this->builder->whereIn('app_id', $this->attribute);
    }
}
