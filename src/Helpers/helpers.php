<?php

if (!function_exists('getEnumValues')) {
    function getEnumValues(array $cases): array
    {
        $result = [];
        foreach ($cases as $case) {
            $result[] = $case->name;
        }
        return $result;
    }
}
