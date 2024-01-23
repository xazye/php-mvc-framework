<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_MINLENGTH = 'min';
    public const RULE_MAXLENGTH = 'max';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCHES = 'matches';
    public const RULE_IS_UNIQUE = 'is_unique';
    // public const RULE_IS_IN_DB = 'is_in_db';
    public array $errors = [];
    public function attributeLabels(): array{
        return[];
    }
    abstract public function rules(): array;

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {

                $this->$key = $value;
            }
        }
    }
    public function validate()
    {
        foreach ($this->rules() as $attribute => $value) {
            $rules = $value['rules'];
            $value = $this->$attribute;
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName == self::RULE_REQUIRED && empty($value)) {
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName == self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorForRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName == self::RULE_MINLENGTH && strlen($value) < $rule['min']) {
                    $this->addErrorForRule($attribute, self::RULE_MINLENGTH, $rule);
                }
                if ($ruleName == self::RULE_MAXLENGTH && strlen($value) > $rule['max']) {
                    $this->addErrorForRule($attribute, self::RULE_MAXLENGTH, $rule);
                }

                if ($ruleName == self::RULE_MATCHES && $value != $this->{$rule['match']}) {
                    $this->addErrorForRule($attribute, self::RULE_MATCHES, ['match' => $this->attributeLabels()[$attribute]]);
                }
                if ($ruleName == self::RULE_IS_UNIQUE) {
                    $class = $rule['class'];
                    $uniqueAttribiute = $rule['attribute'] ?? $attribute;
                    $tableName = $class::tableName();
                    $statement = Application::$APP->db->prepare("SELECT * FROM $tableName WHERE $uniqueAttribiute = :attr");
                    $statement->bindValue(':attr', $value);
                    $statement->execute();
                    if ($statement->rowCount()) {
                        $this->addErrorForRule($attribute, self::RULE_IS_UNIQUE, ['field' =>  $this->attributeLabels()[$attribute]]);
                    }
                }
            }
        }
        return $this->errors ? false : true;
    }

    private function addErrorForRule(string $attribute, string $rule, array $params = [])
    {
        var_dump($params);
        $message = $this->errorMessages()[$rule];
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }
    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_MINLENGTH => 'This field must have at least {min} characters',
            self::RULE_MAXLENGTH => 'This field must have at most {max} characters',
            self::RULE_EMAIL => 'This field must be a valid email',
            self::RULE_MATCHES => 'This field must match {match} field',
            self::RULE_IS_UNIQUE => 'Record with this {field} already exists',
        ];
    }
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
