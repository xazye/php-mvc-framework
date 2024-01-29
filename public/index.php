<?php

use app\controllers\AuthController;
use app\controllers\SiteController;
use app\core\Application;

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

$app->router->add('contactform','/contact', [SiteController::class, 'contact']);
$app->router->add('index','/login', [AuthController::class, 'login']);
$app->router->add('registration','/register', [AuthController::class, 'register']);
$app->router->add('logout','/logout', [AuthController::class, 'logout']);
$app->router->add('profile','/profile', [AuthController::class, 'profile']);

$app->router->add('index','/', [SiteController::class, 'home']);


$app->run();
