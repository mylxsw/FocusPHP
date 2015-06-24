<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Demo;

use Focus\BasicContainer;
use Focus\Container;
use Focus\MVC\Router;
use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Server;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';

$logger = new Logger('focusphp');
$logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/focusphp.log'));

$basicContainer = new BasicContainer();
$basicContainer->set(LoggerInterface::class, $logger);

$server = Server::init(Container::instance()->setContainer($basicContainer));
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
