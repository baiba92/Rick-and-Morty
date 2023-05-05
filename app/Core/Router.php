<?php declare(strict_types=1);

namespace App\Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class Router
{
    public static function response(array $routes)
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $router) use ($routes) {
            foreach ($routes as $route) {
                [$httpMethod, $url, $handler] = $route;
                $router->addRoute($httpMethod, $url, $handler);
            }
        });

        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($httpMethod, $uri);
        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return null;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];

                [$controllerName, $methodName] = $handler;
                $controllerName = new $controllerName;

                return $controllerName->{$methodName}();
        }
        return null;
    }
}