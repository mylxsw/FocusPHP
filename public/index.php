<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Demo;

use Focus\Loader;
use Focus\MVC\Router;
use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Server;

require __DIR__ . '/../vendor/autoload.php';

// 设置默认的Loader
Loader::instance()->setLoader(new Loader\DefaultLoader());

$server = Server::init();
// 注册项目命名空间及根目录
$server->registerAutoloader(__DIR__, 'Demo');
$server->registerExceptionHandler(function($exception) {
    echo "<pre>";
    echo $exception;
    echo "</pre>";
});

// 先注册者优先
$server->registerRouter(new Router('Demo\Controllers'));
$server->registerRouter('user', function(
    Request $request,
    Response $response) {

    $response->write("hello, world");
});


$server->run();
