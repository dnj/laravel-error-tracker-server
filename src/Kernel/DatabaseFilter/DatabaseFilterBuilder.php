<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class DatabaseFilterBuilder
{
    public function __construct(protected Builder $builder, protected array $attributes, protected string $namespace)
    {
    }

    public function build(): Builder
    {
        foreach ($this->attributes as $key => $attribute) {

            $normalizeName = ucfirst(Str::camel($key));
            $className = sprintf('%s\\%s', $this->namespace, $normalizeName);
            if (!class_exists($className)) {
                throw new \Exception();
            }
            $filterInstants = new $className($this->builder);
            $filterInstants->setAttribute($attribute);
            $filterInstants->handel();
        }

        return $this->builder;
    }
}
