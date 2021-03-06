<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\MVC;

use Focus\Exception\HttpNotFoundException;
use Focus\Log\LoggerAwareTrait;
use Focus\Request\Request;
use Focus\Response\Response;
use Focus\Router\Route;

class Router implements Route
{
    use LoggerAwareTrait;

    private $_controllerName = 'Index';
    private $_actionName = 'index';
    private $_pathParams = [];

    private $_controllerNs = '';
    private $_rewriteRules;

    public function __construct($controllerNs, $rewriteRules = [])
    {
        $this->_controllerNs = rtrim($controllerNs, '\\');
        $this->_rewriteRules = $rewriteRules;
    }

    /**
     * Determine whether the routing rules is matched.
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    rule index
     *
     * @return bool
     */
    public function isMatched($pathinfo, $index)
    {
        $pathinfo = $this->_urlRewrite($pathinfo);

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
            if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                $this->getLogger()->debug('pathinfo is empty');
            }
        }

        // 检查控制器是否存在
        $className = "{$this->_controllerNs}\\{$this->_controllerName}";

        if (class_exists($className)) {

            // 检查方法是否存在，不存则则使用index方法
            if (!method_exists($className, $this->_actionName.'Action')) {
                $this->_actionName = 'index';
                if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                    $this->getLogger()->debug('use default action: indexAction');
                }
            }

            return true;
        }

        return false;
    }

    private function _urlRewrite($pathinfo)
    {
        foreach ($this->_rewriteRules as $pattern => $dest) {
            if (preg_match($pattern, $pathinfo)) {
                $pathinfo = preg_replace($pattern, $dest, $pathinfo);
                if (strpos($pathinfo, '?') !== false) {
                    $exp = explode('?', $pathinfo, 2);
                    $pathinfo = $exp[0];
                    parse_str($exp[1], $params);
                    foreach ($params as $key => $val) {
                        $_GET[$key] = $val;
                    }
                }

                break;
            }
        }

        return $pathinfo;
    }

    /**
     * Processing request.
     *
     * @param Request  $request
     * @param Response $response
     * @param mixed    ...$params
     *
     * @return mixed
     */
    public function execute(Request $request, Response $response, ...$params)
    {
        try {
            $className = "{$this->_controllerNs}\\{$this->_controllerName}";
            $methodName = $this->_actionName.'Action';

            $classRefl = new \ReflectionClass($className);

            $instance = $classRefl->newInstance();
            if (method_exists($instance, '__init__')) {
                $instance->__init__();
                if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                    $this->getLogger()->debug("exec: {$className}->__init__");
                }
            }
            if (!method_exists($instance, $methodName)) {
                if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                    $this->getLogger()->debug('the request method not exist');
                }

                throw new HttpNotFoundException('The request method not exist!');
            }

            $methodRefl = $classRefl->getMethod($methodName);
            $paramsRefl = $methodRefl->getParameters();
            $params = [];
            foreach ($paramsRefl as $index => $param) {
                $paramClass = $param->getClass();

                if ($paramClass->implementsInterface('Focus\Request\Request')) {
                    $params[$index] = $request;
                } elseif ($paramClass->implementsInterface('Focus\Response\Response')) {
                    $params[$index] = $response;
                } elseif ($paramClass->implementsInterface('Focus\Request\Session')) {
                    $params[$index] = $request->session();
                } elseif ($paramClass->implementsInterface('Focus\Config\Config')) {
                    $params[$index] = $request->config();
                } elseif ($paramClass->implementsInterface('Focus\MVC\Model')
                           || $paramClass->implementsInterface('Focus\MVC\Service')) {
                    if ($request->container()->has($paramClass->getName())) {
                        $object = $request->container()->get($paramClass->getName());
                    } else {
                        $object = $paramClass->newInstance();
                    }
                    $params[$index] = $object;
                    $params[$index]->init();
                } elseif ($paramClass->implementsInterface('Focus\MVC\View')) {
                    $params[$index] = $paramClass->newInstance();
                } else {
                    if (!empty($this->_pathParams)) {
                        $params[$index] = array_shift($this->_pathParams);
                    }
                }
            }

            $res = $instance->{$methodName}(...$params);
            if ($res instanceof View) {
                if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                    $this->getLogger()->debug('use view object for response');
                }

                $res->output($response);
            } elseif (is_string($res) || is_numeric($res)) {
                if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                    $this->getLogger()->debug('use scalar type for response');
                }

                $response->write($res);
            }

            return $res;
        } catch (\ReflectionException $exception) {
            if (defined('FOCUS_DEBUG') && FOCUS_DEBUG) {
                $this->getLogger()->debug(sprintf(
                    'reflection exception: [%s] %s',
                    $exception->getCode(),
                    $exception->getMessage()
                ));
            }
            throw new \RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * Whether to continue the search for routes.
     *
     * @return bool
     */
    public function isContinue()
    {
        return false;
    }
}
