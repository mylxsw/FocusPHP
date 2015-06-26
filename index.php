<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/public');

$basicContainer = new \Focus\BasicContainer(__DIR__ . '/public/Configs/container.php');
$server = \Focus\Server::init(\Focus\Container::instance()->setContainer($basicContainer));
// 注册项目命名空间及根目录
$server->registerAutoloader(__DIR__ . '/public', 'Demo');
$server->registerExceptionHandler(function($exception) {
    echo "<pre>";
    echo $exception;
    echo "</pre>";
});

// 先注册者优先
$server->registerRouter(new \Focus\MVC\Router('Demo\Controllers',[
    '/^article\/([0-9]+).html$/'  => 'post/show?id=$1',
    '/^category\/([0-9]+).html$/'  => 'post/list?cat=$1'
]));

$server->run();
