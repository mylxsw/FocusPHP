<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus;


use Focus\Router\DefaultRouter;
use Focus\Router\Route;

class Router {

    /**
     * @var Router\Route[]
     */
    private $_routers = [];

    /**
     * 新增路由规则
     *
     * @param mixed $router
     * @param array $params
     */
    public function add($router, ...$params) {
        if ($router instanceof Route) {
            $this->_routers[] = $router;
        } else if (is_string($router)) {
            $this->_routers[] = new DefaultRouter($router, ...$params);
        } else {
            throw new \RuntimeException("不合法的路由规则!");
        }
    }

    /**
     * 路由规则解析
     *
     * @return array
     */
    public function parse() {
        $matched = [];
        foreach ($this->_routers as $router) {
            if ($router->isMatched($this->getPathInfo(), count($matched))) {
                $matched[] = $router;
                if ($router->isContinue() === false) {
                    break;
                }
            }
        }

        return $matched;
    }

    /**
     * @return string
     */
    public function getPathInfo() {
        return Loader::instance()->getUri()->getPathInfo();
    }
} 