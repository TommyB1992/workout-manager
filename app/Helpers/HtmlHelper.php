<?php

namespace App\Helpers;

class HtmlHelper {
    public static function getTxtInput(string $key): string {
        if (!empty($_POST[$key])) {
            return trim($_POST[$key]);
        }

        return '';
    }

    public static function getIntInput(string $key, bool $forceInt = true): ?int {
        if (!empty($_POST[$key])) {
            return (int) $_POST[$key];
        }

        return $forceInt ? 0 : null;
    }

    public static function getInputReferer(string $page): string {
        return '<input type="hidden" name="referer" value="' . 
            htmlspecialchars($_POST['referer'] ?? $_SERVER['HTTP_REFERER'] ?? $page) . 
            '">';
    }

    public static function getSendedInput(string $key, int|string $value = ''): string {
        return htmlspecialchars(trim($_POST[$key] ?? $value));
    }

    public static function getIdInput(string $prefix, bool $forceInt = true): ?int {
        $key = $prefix . '_id';
        return self::getIntInput($key, $forceInt);
    }

    public static function getNameInput(): string {
        return self::getTxtInput('name');
    }
}