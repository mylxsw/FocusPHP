<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:29
 */

namespace Focus\Router;


use Focus\Request\Request;
use Focus\Response\Response;

class MVCRouter implements Route {

    private $_controllerName = 'index';
    private $_actionName = 'index';

    private $_controllerNs = '';

    public function __construct($controllerNs) {
        $this->_controllerNs = rtrim($controllerNs, '\\');
    }

    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     *
     * @return bool
     */
    public function isMatched( $pathinfo ) {
        if (!empty($pathinfo)) {
            $res = explode('/', $pathinfo, 2);
            $this->_controllerName = ucfirst($res[0]);
            if (count($res) == 2) {
                $this->_actionName = $res[1];
            }
        }

        // 检查控制器是否存在
        $className = "{$this->_controllerNs}\\{$this->_controllerName}";
        if (class_exists($className)) {

            // 检查方法是否存在，不存则则使用index方法
            if (!method_exists($className, $this->_actionName . 'Action')) {
                $this->_actionName = 'index';
            }

            return true;
        }

        return false;
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
        return call_user_func_array(
            [
                "{$this->_controllerNs}\\{$this->_controllerName}",
                $this->_actionName . "Action"
            ],
            [$request, $response]
        );
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