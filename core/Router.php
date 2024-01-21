<?php

namespace app\core;

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
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }
    /**
     * The resolve function checks if a route exists and returns the corresponding callback or renders
     * a view if the callback is a string.
     * 
     * @return either a string "Not found" if the callback is false, or the result of calling the
     * callback function.
     */
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView('_404');
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            Application::$APP->controller = new $callback[0];
            $callback[0] = Application::$APP->controller;
        }
        return call_user_func($callback,$this->request);
    }
    public function renderView($view, array $params=[])
    {
        $layoutContent = $this->layoutContent();
        $view = $this->renderOnlyView($view,$params);
        return str_replace('{{content}}', $view, $layoutContent);
    }
    /**
     * The function "layoutContent" includes the main layout file and returns its content.
     * 
     * @return string HTML output of the included file "main.php" after buffering it using the ob_start() and
     * ob_get_clean() functions.
     */
    protected function layoutContent()
    {
        $layout= Application::$APP->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/{$layout}.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view, array $params=[])
    {
        foreach ($params as $key => $value) {
            ${$key} = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/{$view}.php";
        return ob_get_clean();
    }
}
