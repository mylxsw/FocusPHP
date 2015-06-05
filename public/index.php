<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 16:56
 */
namespace Demo;

use Focus\Router\MVCRouter;

require __DIR__ . '/autoload.php';

$server = \Focus\Server::init();

// 先注册者优先
$server->map(new MVCRouter('Demo\Controllers'));
$server->map('user', function(
    \Focus\Request\Request $request,
    \Focus\Response\Response $response) {

    $response->write("hello, world");
});



$server->run();