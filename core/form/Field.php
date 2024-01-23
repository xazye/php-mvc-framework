<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    // public const TYPE_CHECKBOX= 'checkbox';
    // public const TYPE_RADIO= 'radio';
    // public const TYPE_SUBMIT='submit';
    // public const TYPE_FILE= 'file';

    public Model $model;
    public string $attribute;
    public string $type;
    public function __construct(Model $model, string $attribute, string $type = 'text')
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = $type;
    }
    public function __toString()
    {
        $name = $this->attribute;
        $value = $this->model->{$this->attribute};
        $labelname = $this->model->attributeLabels()[$this->attribute] ?? $this->attribute;
        // 
        // refactor this
        $html =
            "<div class='form-group mb-3'>
            <label for={$name} class='form-label'>" . $labelname . "</label>
            " . sprintf(
                "<input type={$this->type} class='form-control %s' name={$name} id={$name} value={$value}>",
                $this->model->hasError($name) ? 'is-invalid' : ''
            ) .
            "<div class='invalid-fedback'>" .
            sprintf($this->model->getFirstError($name)) .
            "</div>
          </div>";
        return $html;
    }
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}
