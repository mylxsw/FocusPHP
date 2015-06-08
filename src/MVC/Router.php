<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\MVC;


use Focus\Exception\HttpNotFoundException;
use Focus\Loader;
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
     * Determine whether the routing rules is matched
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    rule index
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
     * Processing request
     *
     * @param Request $request Request Object
     * @param Response $response Response Object
     * @param mixed $params
     *
     * @return void
     */
    public function execute( Request $request, Response $response, ...$params ) {
        try {
            $className = "{$this->_controllerNs}\\{$this->_controllerName}";
            $methodName = $this->_actionName . "Action";

            $classRefl = new \ReflectionClass($className);

            $instance = $classRefl->newInstance();
            if (!method_exists($instance, $methodName)) {
                throw new HttpNotFoundException('请求的方法不存在');
            }

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
                } else if ($paramClass->implementsInterface('Focus\Config\Config')) {
                    $params[$index] = $request->config();
                } else if ($paramClass->implementsInterface('Focus\MVC\Model')
                           || $paramClass->implementsInterface('Focus\MVC\Service')) {
                    $params[$index] = $paramClass->newInstance();
                    $params[$index]->init();
                } else {
                    if (!empty($this->_pathParams)) {
                        $params[$index] = array_shift($this->_pathParams);
                    }
                }
            }

            return $instance->{$methodName}(...$params);
        } catch (\ReflectionException $exception) {
            throw new \RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Whether to continue the search for routes
     *
     * @return bool
     */
    public function isContinue() {
        return false;
    }
}