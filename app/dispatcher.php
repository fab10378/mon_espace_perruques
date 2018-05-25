<?php
/**
 * This file handle routes dispatching.
 *
 * PHP version 7
 *
 * @author   WCS <contact@wildcodeschool.fr>
 *
 */


require_once __DIR__ . '/routing.php';

$routesCollection = function (FastRoute\RouteCollector $r) use ($routes) {
    foreach ($routes as $controller => $actions) {
        foreach ($actions as $action) {
            $r->addRoute($action[2], $action[1], $controller . '/' . $action[0]);
        }
    }
    $r->addRoute('POST','/rendezvous/file','Item/contactAction');
};


$dispatcher = FastRoute\simpleDispatcher($routesCollection);

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo call_user_func([new \Controller\ItemController(), 'error404Action']);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        list($class, $method) = explode("/", $handler, 2);
        $class = APP_CONTROLLER_NAMESPACE . $class . APP_CONTROLLER_SUFFIX;
        echo call_user_func_array([new $class(), $method], $vars);
        break;
}