<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 16:56
 */
namespace Demo;

use Focus\MVC\Router;
use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Server;

require __DIR__ . '/../vendor/autoload.php';

$server = Server::init();
$server->registerAutoloader(__DIR__, 'Demo');

// 先注册者优先
$server->registerRouter(new Router('Demo\Controllers'));
$server->registerRouter('user', function(
    Request $request,
    Response $response) {

    $response->write("hello, world");
});



$server->run();