<?php
namespace app\core\form;

use app\core\Model;

abstract class BaseField{
    public Model $model;
    public string $attribute;
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    abstract public function renderInput():string;
    public function __toString()
    {
        $name = $this->attribute;
        $labelname = $this->model->attributeLabels()[$this->attribute] ?? $this->attribute;
        // 
        // refactor this
        $html =
            "<div class='form-group mb-3'>
            <label for={$name} class='form-label'> {$labelname} </label> 
            {$this->renderInput()} 
            <div class='invalid-fedback'>
            {$this->model->getFirstError($name)}
            </div>
          </div>";
        return $html;
    }
}