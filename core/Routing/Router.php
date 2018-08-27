<?php

namespace Core\Routing;

/**
 * Route handler.
 */
class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => [],
    ];

    /**
     * Fetch the uri and controller for GET request.
     *
     * @param  $uri
     * @param  $controller
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Fetch the uri and controller for POST request.
     *
     * @param  $uri
     * @param  $controller
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }

    /**
     * Load the routes file.
     *
     * @param  $file
     *
     * @return $router
     */
    public static function load($file)
    {
        $router = new static();

        require $file;

        return $router;
    }

    /**
     * Direct the traffic to specified uri.
     *
     * @param  $uri request uri string
     * @param  $requestType
     *
     * @throws Exception
     */
    public function direct($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }

        throw new Exception('No routes found with the uri '.$uri, 404);
    }

    /**
     * Get the controller and call the action.
     *
     * @param $controller
     * @param $action
     *
     * @return string
     *
     * @throws Exception
     */
    public function callAction($controller, $action)
    {
        $controller = "App\\Http\\Controllers\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $action)) {
            throw new Exception("{$controller} has no method {$action}");
        }

        return $controller->$action();
    }
}