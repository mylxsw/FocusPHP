<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:29
 */

namespace Focus\MVC;


use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Router\Route;

class Router implements Route {

    private $_controllerName = 'index';
    private $_actionName = 'index';
    private $_pathParams = [];

    private $_controllerNs = '';

    public function __construct($controllerNs) {
        $this->_controllerNs = rtrim($controllerNs, '\\');
    }

    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    路由规则索引
     *
     * @return bool
     */
    public function isMatched( $pathinfo, $index) {
        if (!empty($pathinfo)) {
            $res = explode('/', $pathinfo);
            $this->_controllerName = ucfirst($res[0]);
            if (count($res) >= 2) {
                $this->_actionName = $res[1];
            }

            if (count($res) > 2) {
                $this->_pathParams = array_slice($res, 2);
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
        $className = "{$this->_controllerNs}\\{$this->_controllerName}";
        $methodName = $this->_actionName . "Action";

        $classRefl = new \ReflectionClass($className);
        $methodRefl = $classRefl->getMethod($methodName);
        $paramsRefl = $methodRefl->getParameters();
        $params = [];
        foreach ($paramsRefl as $index => $param) {
            $paramClass = $param->getClass();

            if ($paramClass->implementsInterface('Focus\Request\Request')) {
                $params[$index] = $request;
            } else if ($paramClass->implementsInterface('Focus\Response\Response')) {
                $params[$index] = $response;
            } else if ($paramClass->implementsInterface('Focus\Request\Session')) {
                $params[$index] = $request->session();
            } else if ($paramClass->implementsInterface('Focus\MVC\Model')) {
                $params[$index] = $paramClass->newInstance();
                $params[$index]->init();
            } else {
                if (!empty($this->_pathParams)) {
                    $params[$index] = array_shift($this->_pathParams);
                }
            }
        }

        return $classRefl->newInstance()->{$methodName}(...$params);
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