<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;

class AuthController extends Controller
{
    public function login(Request $request,Response $response)
    {
        $this->setLayout('auth');
        $loginFrom = new LoginForm();
        if ($request->isPost()) {
            $loginFrom->loadData($request->getBody());
            if ($loginFrom->validate() && $loginFrom->login()) {
                Application::$APP->session->setFlash('success', 'Welcome back');
                $response->redirect('/');
                return;
            }
            return $this->render('login', ['model' => $loginFrom]);
        }
        return $this->render('login',['model' => new LoginForm()]);
    }
    public function register(Request $request,Response $response)
    {
        $this->setLayout('auth');
        if ($request->isPost()) {
            $user = new User();
            $user->loadData($request->getBody());
            if ($user->validate() && $user->save()) {
                Application::$APP->session->setFlash('success', 'Thanks for registering');
                $response->redirect('/');
                return;
            }
            return $this->render('register', ['model' => $user]);
        }
        return $this->render('register', ['model' => new User()]);
    }
    public function logout(Request $request,Response $response){
        Application::$APP->logout();
        $response->redirect('/');
    }
}
