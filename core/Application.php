<?php

namespace app\core;


/**
 * @package app\Application;
 */
class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static string $ROOT_DIR;
    public static Application $APP;
    public Controller $controller;
    public Session $session;
    public string $userClass;
    public ?DbModel $user;
    public function __construct($rootPath,array $config)
    {
        $this->userClass = $config['userClass'];
        self::$APP = $this;
        self::$ROOT_DIR = $rootPath;
        $this->request = new Request();
        $this->response = new Response();
        $this->controller = new Controller();
        $this->db = new Database($config['db']);
        $this->router = new Router($this->request,$this->response);
        $this->session = new Session();

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
        echo $this->router->resolve();
    }
    public function login(DbModel $user){
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
