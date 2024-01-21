<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    public string $nickname;
    public string $email;
    public string $password;
    public string $password_repeat;
    public function register()
    {
    }
    public function rules(): array
    {
        return [
            'nickname' => [
                'rules' => [self::RULE_REQUIRED,[Self::RULE_MINLENGTH,'min'=>3]],
            ],
            'email' => [
                'rules' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            ],
            'password' => [
                'rules' => [Self::RULE_REQUIRED],
            ],
            'password_repeat' => [
                'rules' => [self::RULE_REQUIRED, [Self::RULE_MATCHES, 'match'=>'password']],
            ]
        ];
    }
}
