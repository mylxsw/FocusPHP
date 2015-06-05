<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 17:41
 */

namespace Focus;


use Focus\Router\DefaultRouter;
use Focus\Router\Route;

class Router {

    /**
     * @var Router\Route[]
     */
    private $_routers = [];

    private $_pathInfo = '';

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
            if ($router->isMatched($this->getPathInfo())) {
                $matched[] = $router;
            }
        }

        return $matched;
    }


    public function getPathInfo() {
        return $this->_pathInfo;
    }

    public function setPathInfo($pathInfo) {
        $this->_pathInfo = $pathInfo;
    }
} 