<?php

namespace app\core\form;

use app\core\Model;
use app\core\form\BaseField;

class TextAreaField extends BaseField
{
    public const TYPE_TEXTAREA = 'textarea';
    public function __construct(Model $model, string $attribute)
    {
        parent::__construct($model, $attribute);
    }
    public function renderInput(): string
    {
        return sprintf(
            '<textarea class="form-control %1$s" name=%2$s id=%2$s rows="3" value=%3$s></textarea>',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute}
        );
    }
}
