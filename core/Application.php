<?php

namespace app\core;

use app\core\db\Database;
use app\core\db\DbModel;
use Symfony\Component\HttpFoundation\Request as Requestsymfony;

/**
 * @package app\Application;
 */
class Application
{
    public Router $router;
    public Requestsymfony $request;
    public Response $response;
    public Database $db;
    public static string $ROOT_DIR;
    public static Application $APP;
    public Controller $controller;
    public Session $session;
    public string $userClass;
    public ?UserModel $user;
    public View $view;
    public function __construct($rootPath,array $config)
    {
        $this->userClass = $config['userClass'];
        self::$APP = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Requestsymfony();
        $this->response = new Response();
        $this->controller = new Controller();
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request,$this->response);
        $this->session = new Session();
        $this->view = new View();

        $primaryVal= $this->session->get('user');
        if($primaryVal){
            $instance = new $this->userClass();
            $primaryKey=  $instance->primaryKey();
            $this->user= $instance->findOne([$primaryKey=>$primaryVal]);
        }else{
            $this->user=null;
        }
    }
    public static function isGuest() :bool{
        return self::$APP->user === null;
    }
    public function run()
    {
        $response = $this->router->resolve();
        $response->send();
       
    }
    public function login(UserModel $user){
        $this->user = $user;
        $primaryKey = $user->primaryKey();
        $primaryVal = $user->{$primaryKey};
        $this->session->set('user', $primaryVal);
        return true;
    }
    public function logout(){
        $this->user = null;
        $this->session->remove('user');
    }
}
