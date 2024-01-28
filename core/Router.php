<?php

namespace app\core;
use app\core\exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;


/**
 * @package app\Application;
 */
class Router
/**
 * Router class handles routing in the application.
 * 
 * It contains routes and can match requests to routes to execute the associated callbacks.
 * It can also render views and layouts.
 */
{
    protected array $routes = [];
    public Requestsymfony $request;
    public Response $response;

    public function __construct(Requestsymfony $request, Response $response)
    {
        $this->request = $request::createFromGlobals();
        $this->response = $response;
    }
    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }
    /**
     * The resolve function checks if a route exists and returns the corresponding callback or renders
     * a view if the callback is a string.
     * 
     * @return mixed "Not found" if the callback is false, or the result of calling the
     * callback function.
     */
    public function resolve()
    {
        $path = $this->request->getPathInfo();;
        $method = $this->request->server->get('REQUEST_METHOD');
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$APP->view->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback[0]();
            Application::$APP->controller = $controller;
            $controller->action = $callback[1];
            foreach ($controller->getMiddlewares()as $middleware){
                $middleware->execute();
            }
            $callback[0] = $controller;

        }
        return call_user_func($callback, $this->request, $this->response);
    }
}
