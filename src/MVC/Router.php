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
use Focus\Log\LoggerAwareTrait;
use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Router\Route;

class Router implements Route {

    use LoggerAwareTrait;

    private $_controllerName = 'index';
    private $_actionName = 'index';
    private $_pathParams = [];

    private $_controllerNs = '';
    private $_rewriteRules;

    public function __construct($controllerNs, $rewriteRules = []) {
        $this->_controllerNs = rtrim($controllerNs, '\\');
        $this->_rewriteRules = $rewriteRules;
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
        if (is_array($this->_rewriteRules) && isset($this->_rewriteRules[$pathinfo])) {
            $pathinfo = $this->_rewriteRules[$pathinfo];
        }

        if (!empty($pathinfo)) {
            $res = explode('/', $pathinfo);
            $this->_controllerName = empty($res[0]) ? $this->_controllerName : ucfirst($res[0]);
            if (count($res) >= 2) {
                $this->_actionName = empty($res[1]) ? $this->_actionName : $res[1];
            }

            if (count($res) > 2) {
                $this->_pathParams = array_slice($res, 2);
            }

        } else {
            $this->getLogger()->debug('pathinfo is empty');
        }

        // 检查控制器是否存在
        $className = "{$this->_controllerNs}\\{$this->_controllerName}";

        if (class_exists($className)) {

            // 检查方法是否存在，不存则则使用index方法
            if (!method_exists($className, $this->_actionName . 'Action')) {
                $this->_actionName = 'index';
                $this->getLogger()->debug('use default action: indexAction');
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
            if (method_exists($instance, '__init__')) {
                $instance->__init__();
                $this->getLogger()->debug("exec: {$className}->__init__");
            }
            if (!method_exists($instance, $methodName)) {
                $this->getLogger()->debug('the request method not exist');
                throw new HttpNotFoundException('The request method not exist!');
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

                    if ($request->container()->has($paramClass->getName())) {
                        $object = $request->container()->get($paramClass->getName());
                    } else {
                        $object = $paramClass->newInstance();
                    }
                    $params[$index] = $object;
                    $params[$index]->init();
                } else if ($paramClass->implementsInterface('Focus\MVC\View')) {
                    $params[$index] = $paramClass->newInstance();
                } else {
                    if (!empty($this->_pathParams)) {
                        $params[$index] = array_shift($this->_pathParams);
                    }
                }
            }

            $res = $instance->{$methodName}(...$params);
            if ($res instanceof View) {
                $this->getLogger()->debug('use view object for response');
                $res->output($response);
            } else if (is_string($res) || is_numeric($res)) {
                $this->getLogger()->debug('use scalar type for response');
                $response->write($res);
            }
            return $res;
        } catch (\ReflectionException $exception) {
            $this->getLogger()->warning(sprintf(
                'reflection exception: [%s] %s',
                $exception->getCode(),
                $exception->getMessage()
            ));
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