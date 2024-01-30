<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    public string $layout='main';
    public string $action = '';

    /**
     * @var array app\core\middlewares\BaseMiddleware $middlewares
     */
    protected array $middlewares=[];
    /**
     * Renders a view with the given parameters.
     * 
     * @param string $view The name of the view to render.
     * @param array $params An array of parameters to pass to the view.
     * 
     * @return string The rendered view content.
     */
    public function render(string $view, $params=[])
    {
        return Application::$APP->view->renderView($view, $params);
    }
    public function setLayout($layout){
        $this->layout = $layout;
    }
    public function registerMiddleware(BaseMiddleware $middleware){
        $this->middlewares[] = $middleware;
    }
    public function getMiddlewares(){
        return $this->middlewares;
    }
}
