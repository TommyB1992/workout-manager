<?php
namespace App\Core;


class ViewVars {
    public static array $vars = [];

    public static function set(string|array $key, ?string $value = null, bool $sanitize = true): void {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                self::$vars[$k] = $sanitize ? self::sanitizeRecursive($v) : $v;
            }
        } else {
            self::$vars[$key] = $sanitize ? self::sanitizeRecursive($value) : $value;
        }
    }

    public static function get(string $key): mixed {
        return self::$vars[$key] ?? null;
    }

    private static function sanitizeRecursive(mixed $data): mixed {
        if (is_string($data)) {
            return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        } elseif (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = self::sanitizeRecursive($value);
            }
        }
        return $data;
    }
}


class View {
    public static function setGlobal(string|array $key, ?string $value = null, bool $sanitize = true): void {
        ViewVars::set($key, $value, $sanitize);
    }

    public static function render(string $view, array $params = [], string $layout = 'layout'): void {
        $globals = ViewVars::$vars ?? [];
        extract($globals);
        extract($params);

        $viewPath = __DIR__ . '/../Views/' . $view . '.php';
        $layoutPath = __DIR__ . '/../Views/' . $layout . '.php';

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require $layoutPath;
    }

    public static function renderPartial(string $view, array $params = []): void {
        $globals = ViewVars::$vars ?? [];
        extract($globals);
        extract($params);
        require __DIR__ . '/../Views/' . $view . '.php';
    }
}