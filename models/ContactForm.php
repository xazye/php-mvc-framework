<?php

namespace app\models;

use app\core\Application;
use app\core\Model;

class ContactForm extends Model
{
    public string $email = '';
    public string $subject = '';
    public string $body = '';
    public string $checkbox = '';
    public function rules(): array
    {
        return [
            'email' => [
                'rules' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            ],
            'subject' => [
                'rules' => [self::RULE_REQUIRED],
            ],
            'body' => [
                'rules' => [self::RULE_REQUIRED],
            ],
            'checkbox' => [
                'rules' => [self::RULE_REQUIRED],
            ],
        ];
    }
    public function attributeLabels(): array
    {
        return [
            'email' => 'Username',
            'subject' => 'Password',
            'body' => 'textarea',
        ];
    }
    public function send(){
        
    }
}
