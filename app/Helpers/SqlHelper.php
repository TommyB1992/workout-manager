<?php

namespace App\Helpers;

class SqlHelper {
    public static function buildPlaceholders(array $dates): string {
        return implode(',', array_fill(0, count($dates), '?'));
    }
}