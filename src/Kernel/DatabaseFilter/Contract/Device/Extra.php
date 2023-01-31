<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Contract\Device;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract\FiltersAbstract;

class Extra extends FiltersAbstract
{
    /**
     * @return void
     */
    public function handel(): void
    {
        $this->builder->where('extra', 'LIKE', '%'.$this->attribute.'%');
    }
}
