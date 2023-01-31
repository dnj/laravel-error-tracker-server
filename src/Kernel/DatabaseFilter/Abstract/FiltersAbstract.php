<?php

namespace dnj\ErrorTracker\Laravel\Server\Kernel\DatabaseFilter\Abstract;

use Illuminate\Database\Eloquent\Builder;

abstract class FiltersAbstract
{
    protected mixed $attribute;

    public function __construct(protected Builder $builder)
    {
    }

    abstract public function handel();

    public function setAttribute(mixed $attribute): FiltersAbstract
    {
        $this->attribute = $attribute;

        return $this;
    }
}
