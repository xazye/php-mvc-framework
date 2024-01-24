<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    public static function end()
    {
        echo '</form>';
    }
    public function field(Model $model,$attribute,$type){
        if ($type === TextAreaField::TYPE_TEXTAREA){
            return new TextAreaField($model,$attribute);

        }
        return new InputField($model,$attribute,$type);

    }
}
