<?php

namespace dnj\ErrorTracker\Laravel\Server\Helpers;

class Helper
{
    public static function getAllValues(mixed $enum): array
    {
        return array_column($enum, 'name');
    }
}
