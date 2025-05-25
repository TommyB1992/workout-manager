<?php

namespace Core;

class Router {
    protected array $routes = [];

    public function get(string $path, callable $action): void {
        $this->routes['GET'][] = ['path' => $path, 'action' => $action];
    }

    public function post(string $path, callable $action): void {
        $this->routes['POST'][] = ['path' => $path, 'action' => $action];
    }

    public function dispatch(string $method, string $uri): void {
        $uri = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] ?? [] as $route) {
            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([a-zA-Z0-9_-]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($route['action'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}