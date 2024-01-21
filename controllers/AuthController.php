<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }
    // public function handleLogin(Request $request)
    // {
    //     $body = $request->getBody();
    //     $email = $body['email'];
    //     $password = $body['password'];
    //     $user = User::where('email', $email)->first();
    //     if ($user) {
    //         if (password_verify($password, $user->password)) {
    //             $_SESSION['user'] = $user;
    //             return $this->redirect('/dashboard');
    //         }
    //     }
    //     return $this->redirect('/login');
    // }
    // public function logout()
    // {
    //     unset($_SESSION['user']);
    //     return $this->redirect('/login');
    // }
    public function register(Request $request)  
    {
        if($request->isPost()){
            $registerModel = new RegisterModel();
            $registerModel->loadData($request->getBody());
            if($registerModel->validate() && $registerModel->register()){
                return 'success';
            }
            return $this->render('register',['model'=>$registerModel]);
        }
        $this->setLayout('auth');
        return $this->render('register');
    }
}