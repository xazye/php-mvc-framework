<?php

namespace app\core;

class Controller
{

    /**
     * Renders a view with the given parameters.
     * 
     * @param string $view The name of the view to render.
     * @param array $params An array of parameters to pass to the view.
     * 
     * @return mixed The rendered view content.
     */
    public string $layout='main';
    public function render(string $view, array $params=[])
    {
        return Application::$APP->router->renderView($view, $params);
    }
    public function setLayout($layout){
        $this->layout = $layout;
    }
}
