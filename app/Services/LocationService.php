<?php
namespace App\Services;

class LocationService
{
    /** @return array<string> */
    public static function all(): array
    {
        $paths = [
            resource_path('data/latvian_cities.json'),
            resource_path('data/latvian_villages.json'),
            resource_path('data/latvian_municipalities.json'),
        ];

        $all = [];
        foreach ($paths as $p) {
            $arr = json_decode(@file_get_contents($p), true);
            if (is_array($arr)) $all = array_merge($all, $arr);
        }

        $all = array_values(array_unique(array_map('trim', array_filter($all, fn($v) => is_string($v) && $v !== ''))));
        sort($all, SORT_NATURAL | SORT_FLAG_CASE);
        return $all;
    }
}