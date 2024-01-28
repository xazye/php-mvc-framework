<?php

namespace app\controllers;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;


use app\core\Application;
use app\core\Controller;
use app\core\Response;
use app\models\LoginForm;
use app\models\User;
use app\core\middlewares\AuthMiddleware;
class AuthController extends Controller
{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    public function login(Requestsymfony $request, Response $response)
    {
        $this->setLayout('auth');
        $loginFrom = new LoginForm();
        if ($request->isMethod('post')) {
            $loginFrom->loadData($request->request->all());
            if ($loginFrom->validate() && $loginFrom->login()) {
                Application::$APP->session->setFlash('success', 'Welcome back');
                $response->redirect('/');
                return;
            }
            return $this->render('login', ['model' => $loginFrom]);
        }
        return $this->render('login', ['model' => new LoginForm()]);
    }
    public function register(Requestsymfony $request, Response $response)
    {
        $this->setLayout('auth');
        if ($request->isMethod('post')) {
            $user = new User();
            $user->loadData($request->request->all());
            if ($user->validate() && $user->save()) {
                Application::$APP->session->setFlash('success', 'Thanks for registering');
                $response->redirect('/');
                return;
            }
            return $this->render('register', ['model' => $user]);
        }
        return $this->render('register', ['model' => new User()]);
    }
    public function logout(Requestsymfony $request, Response $response)
    {
        Application::$APP->logout();
        $response->redirect('/');
    }
    public function profile()
    {
        return $this->render('profile');
    }
}
