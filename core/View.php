<?php 
namespace app\core;
class View{
    public string $title='Home';

    public function renderView($view, $params )
    {
        $view = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
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
        $layout = Application::$APP->controller->layout;
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/{$layout}.php";
        return ob_get_clean();
    }
    protected function renderOnlyView($view, ...$params)
    {
        if(is_array($params[0])){
            foreach ($params[0] as $key => $value) {
                ${$key} = $value;
            }
        }
        ob_start();
        include_once Application::$ROOT_DIR . "/views/{$view}.php";
        return ob_get_clean();
    }
}