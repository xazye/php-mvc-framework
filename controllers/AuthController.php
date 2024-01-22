<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\User;

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
        $this->setLayout('auth');
        if ($request->isPost()) {
            $user = new User();
            $user->loadData($request->getBody());
            if ($user->validate() && $user->save()) {
                Application::$APP->session->setFlash('success', 'Thanks for registering');
                Application::$APP->response->redirect('/');
            }
            return $this->render('register', ['model' => $user]);
        }
        return $this->render('register', ['model' => new User()]);
    }
}
