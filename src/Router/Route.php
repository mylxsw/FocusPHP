<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 17:12
 */

namespace Focus\Router;


use Focus\Request\Request;
use Focus\Response\Response;

interface Route {

    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     *
     * @return bool
     */
    public function isMatched($pathinfo);

    /**
     * 处理请求
     *
     * @param Request  $request  Request Object
     * @param Response $response Response Object
     *
     * @return void
     */
    public function execute(Request $request, Response $response);

    /**
     * 是否继续查找路由
     *
     * @return bool
     */
    public function isContinue();
} 