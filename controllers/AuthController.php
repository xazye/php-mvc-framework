<?php

namespace app\controllers;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;
use Symfony\Component\HttpFoundation\Response as Responsesymfony;
use Symfony\Component\HttpFoundation\RedirectResponse;


use app\core\Application;
use app\core\Controller;
use app\models\LoginForm;
use app\models\User;
use app\core\middlewares\AuthMiddleware;
class AuthController extends Controller
{
    public function __construct(){
        $this->registerMiddleware(new AuthMiddleware(['profile']));
    }
    public function login(Requestsymfony $request)
    {
        $this->setLayout('auth');
        $loginFrom = new LoginForm();
        if ($request->isMethod('post')) {
            $loginFrom->loadData($request->request->all());
            if ($loginFrom->validate() && $loginFrom->login()) {
                Application::$APP->session->setFlash('success', 'Welcome back');
                return new RedirectResponse('/',301);
            }
            return $this->render('login', ['model' => $loginFrom]);
        }
        return $this->render('login', ['model' => new LoginForm()]);
    }
    public function register(Requestsymfony $request)
    {
        $this->setLayout('auth');
        if ($request->isMethod('post')) {
            $user = new User();
            $user->loadData($request->request->all());
            if ($user->validate() && $user->save()) {
                Application::$APP->session->setFlash('success', 'Thanks for registering');
                return new RedirectResponse('/',301);
            }
            return $this->render('register', ['model' => $user]);
        }
        return $this->render('register', ['model' => new User()]);
    }
    public function logout(Requestsymfony $request)
    {
        Application::$APP->logout();
        return new RedirectResponse('/',301);
    }
    public function profile()
    {
        return  $this->render('profile');
    }
}
