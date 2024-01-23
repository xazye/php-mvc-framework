<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $username = '';
    public string $password = '';
    public function rules(): array
    {
        return [
            'username' => [
                'rules' => [self::RULE_REQUIRED, [self::RULE_MINLENGTH, 'min' => 3]],
            ],
            'password' => [
                'rules' => [self::RULE_REQUIRED],
            ],
        ];
    }
    public function login(): bool
    {
        $dd = new User();
        $user = $dd->findOne(['username' => $this->username]);
        if (!$user) {
            $this->addError('username', 'Invalid username');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Invalid password');
            return false;
        }
        return Application::$APP->login($user);
    }
    public function attributeLabels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }
}
