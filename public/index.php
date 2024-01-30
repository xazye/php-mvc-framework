<?php

use app\core\Application;
use Symfony\Component\Routing\Route;
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();



$config = [
    'userClass' => app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ],
];

$app = new Application(dirname(__DIR__), $config);
$app->router->add('contactform', new Route('/contact',['_controller' => 'app\controllers\SiteController::contact']));
$app->router->add('login',new Route('/login',['_controller'=>'app\controllers\AuthController::login']));
$app->router->add('registration',new Route('/register',['_controller'=>'app\controllers\AuthController::register']));
$app->router->add('logout',new Route('/logout',['_controller'=>'app\controllers\AuthController::logout']));
$app->router->add('profile',new Route('/profile',['_controller'=>'app\controllers\AuthController::profile']));


$app->router->add('index',new Route('/',['_controller' =>'app\controllers\SiteController::home', 'name'=>'Vasya']));


$app->run();
