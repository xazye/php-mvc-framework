<?php

namespace app\core\form;

use app\core\Model;
use app\core\form\BaseField;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_EMAIL = 'email';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_CHECKBOX = 'checkbox';
    public string $type = self::TYPE_TEXT;
    public function __construct(Model $model, string $attribute, $type)
    {
        $this->type = $type;
        parent::__construct($model, $attribute);
    }
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
    public function renderInput(): string
    {
        if ($this->type === self::TYPE_CHECKBOX){
            return sprintf(
                '<input type=%1$s class="form-check %2$s" name=%3$s id=%3$s>',
                $this->type,
                $this->model->hasError($this->attribute) ? 'is-invalid' : '',
                $this->attribute,
            );    
        }
        return sprintf(
            '<input type=%1$s class="form-control %2$s" name=%3$s id=%3$s value=%4$s>',
            $this->type,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute}
        );
    }
}
