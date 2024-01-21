<?php

namespace app\core;


/**
 * @package app\Application;
 */
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static string $ROOT_DIR;
    public static Application $APP;
    public Controller $controller;
    public function __construct($rootPath)
    {
        self::$APP = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->controller = new Controller();
        $this->router = new Router($this->request,$this->response);
    }
    public function run()
    {
        echo $this->router->resolve();
    }
}
