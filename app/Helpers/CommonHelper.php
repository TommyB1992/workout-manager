<?php

namespace App\Helpers;

class CommonHelper {
    public static function redirectToReferer(string $fallback = '/workout'): never {
        header('Location: ' . ($_POST['referer'] ?? $_SERVER['HTTP_REFERER'] ?? $fallback));
        exit;
    }

    public static function isValidFloat(string $value): bool {
        if (!is_numeric($value)) {
            return false;
        }
    
        $float = (float) $value;
        if ($float < 0 || $float > 10000) {
            return false;
        }
    
        // Verifica massimo 2 cifre decimali
        return preg_match('/^\d+(\.\d{1,2})?$/', $value);
    }

    public static function isValidName(string $name): bool {
        $nameLen = strlen($name);
        return $nameLen >= 3 && $nameLen <= 50;
    }
}