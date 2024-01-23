<?php

namespace app\models;

use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETEDS = 2;
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_repeat = '';
    public int $status = self::STATUS_INACTIVE;
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }
    public function tableName(): string
    {
        return 'users';
    }
    public static function primaryKey(): string{
        return 'id';
    }
    public function rules(): array
    {
        return [
            'username' => [
                'rules' => [self::RULE_REQUIRED, [Self::RULE_MINLENGTH, 'min' => 3]],
            ],
            'email' => [
                'rules' => [
                    self::RULE_REQUIRED, self::RULE_EMAIL,
                    [self::RULE_IS_UNIQUE, 'class' => self::class, 'attribute' => 'email']
                ],
            ],
            'password' => [
                'rules' => [Self::RULE_REQUIRED],
            ],
            'password_repeat' => [
                'rules' => [self::RULE_REQUIRED, [Self::RULE_MATCHES, 'match' => 'password']],
            ]
        ];
    }
    public function attributes(): array
    {
        return ['username', 'email', 'password', 'status'];
    }
    public function attributeLabels(): array
    {
        return [
            'username' => 'Username',
            'email' => 'Email address',
            'password' => 'Password',
            'password_repeat' => 'Confirm password',
        ];
    }
    public function getDisplayName():string{
        return $this->username;
    }
}
