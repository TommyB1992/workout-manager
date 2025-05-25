<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\Router;

$router = new Router();

$routes = require __DIR__ . '/../config/routes.php';

foreach ($routes as [$method, $path, [$controllerClass, $methodName]]) {
    $router->{strtolower($method)}($path, function (...$params) use ($controllerClass, $methodName) {
        (new $controllerClass)->$methodName(...$params);
    });
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);