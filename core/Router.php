<?php

namespace app\core;
use app\core\exception\NotFoundException;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;
use Symfony\Component\HttpFoundation\Response as Responsesymfony;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use  Symfony\Component\HttpKernel\Controller\ArgumentResolver;
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
    public UrlMatcher $matcher;
    public ControllerResolver $controllerResolver;
    public ArgumentResolver $argumentResolver;
    public function __construct(Requestsymfony $request)
    {
        $this->routes = new RouteCollection();;
        $this->request = $request::createFromGlobals();
        $this->context = new RequestContext();
        $this->matcher= new UrlMatcher($this->routes,$this->context->fromRequest($this->request));
        $this->controllerResolver= new ControllerResolver();
        $this->argumentResolver= new ArgumentResolver();
    }
    public function add($routename, Route $route)
    {
        $this->routes->add($routename,$route);
    }
    /**
     * The resolve function checks if a route exists and returns the corresponding callback or renders
     * a view if the callback is a string.
     * 
     * @return mixed "Not found" if the callback is false, or the result of calling the
     * callback function.
     */
    public function resolve() :Responsesymfony
    {
        $this->request->attributes->add($this->matcher->match($this->request->getPathInfo()));
        $controller = $this->controllerResolver->getController($this->request);
        // var_dump($controller);
        $arguments = $this->argumentResolver->getArguments($this->request, $controller);
        // var_dump($arguments);
        return call_user_func($controller, ...$arguments);
        // if ($callback === false) {
        //     throw new NotFoundException();
        // }
        // if (is_string($callback)) {
        //     return Application::$APP->view->renderView($callback);
        // }
        // if (is_array($callback)) {
        //     $controller = new $callback['_controller']();
        //     Application::$APP->controller = $controller;
        //     $controller->action = $callback['_action'];
        //     foreach ($controller->getMiddlewares()as $middleware){
        //         $middleware->execute();
        //     }

        // }
    }
}
