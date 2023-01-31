<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Traits;

use dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\DatabaseFilterBuilder;
use dnj\ErrorTracker\Laravel\Server\Models\App;
use dnj\ErrorTracker\Laravel\Server\Models\Device;
use dnj\ErrorTracker\Laravel\Server\Models\Log;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $builder, array $attribute): Builder
    {
        $namespace = $this->findContract();

        return (new DatabaseFilterBuilder($builder, $attribute, $namespace))->build();
    }

    private function findContract(): string
    {
        return match (__CLASS__) {
            App::class => 'dnj\\ErrorTracker\\Laravel\\Server\\Kernel\\DatabaseFilter\\Contract\\App',
            Device::class => 'dnj\\ErrorTracker\\Laravel\\Server\\Kernel\\DatabaseFilter\\Contract\\Device',
            Log::class => 'dnj\\ErrorTracker\\Laravel\\Server\\Kernel\\DatabaseFilter\\Contract\\Log',
        };
    }
}
