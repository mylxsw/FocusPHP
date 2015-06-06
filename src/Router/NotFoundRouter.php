<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/6
 * Time: 12:51
 */

namespace Focus\Router;


use Focus\Request\Request;
use Focus\Response\Response;

class NotFoundRouter implements Route {

    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    路由规则索引
     *
     * @return bool
     */
    public function isMatched( $pathinfo, $index ) {
        return $index == 0;
    }

    /**
     * 处理请求
     *
     * @param Request $request Request Object
     * @param Response $response Response Object
     *
     * @return void
     */
    public function execute( Request $request, Response $response ) {
        $response->header('HTTP/1.1 404 Not Found');
        $response->write("Not Found.");
    }

    /**
     * 是否继续查找路由
     *
     * @return bool
     */
    public function isContinue() {
        return false;
    }
}