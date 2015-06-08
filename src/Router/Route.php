<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\Router;


use Focus\Request\Request;
use Focus\Response\Response;

interface Route {

    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    路由规则索引
     *
     * @return bool
     */
    public function isMatched($pathinfo, $index);

    /**
     * 处理请求
     *
     * @param Request  $request  Request Object
     * @param Response $response Response Object
     * @param mixed    $params   Other parameters
     *
     * @return void
     */
    public function execute(Request $request, Response $response, ...$params);

    /**
     * 是否继续查找路由
     *
     * @return bool
     */
    public function isContinue();
} 