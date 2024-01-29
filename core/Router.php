<?php

namespace app\core;
use app\core\exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

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
    protected RouteCollection $routes;
    public Requestsymfony $request;
    public RequestContext $context;
    public Response $response;
    public UrlMatcher $matcher;

    public function __construct(Requestsymfony $request, Response $response)
    {
        $this->routes = new RouteCollection();;
        $this->request = $request::createFromGlobals();
        $this->response = $response;
        $this->context = new RequestContext();
        $this->matcher= new UrlMatcher($this->routes,$this->context->fromRequest($this->request));
    }
    public function add($routename, $path, $callback)
    {
        $this->routes->add($routename, new Route($path,[
            '_controller' => $callback[0],
            '_action' => $callback[1]
        ]));
        
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
        $callback = $this->matcher->match($path) ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return Application::$APP->view->renderView($callback);
        }
        if (is_array($callback)) {
            $controller = new $callback['_controller']();
            Application::$APP->controller = $controller;
            $controller->action = $callback['_action'];
            foreach ($controller->getMiddlewares()as $middleware){
                $middleware->execute();
            }

        }
        return call_user_func([$controller,$callback['_action']], $this->request, $this->response);
    }
}
