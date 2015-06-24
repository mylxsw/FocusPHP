<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus;


use Focus\Log\LoggerAwareTrait;
use Focus\Router\DefaultRouter;
use Focus\Router\Route;
use Interop\Container\ContainerInterface;
use Focus\Uri\Uri;

class Router {

    use LoggerAwareTrait;

    /**
     * @var Router\Route[]
     */
    private $_routers = [];

    /**
     * @var ContainerInterface
     */
    private $_container;

    public function __construct(ContainerInterface $container) {
        $this->_container = $container;
        $this->getLogger()->debug('master router manger loaded');
    }

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
            $this->getLogger()->error('add new router failed, not a valid router');
            throw new \InvalidArgumentException('INVALID_ROUTER');
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
                $this->getLogger()->debug(sprintf('router %s is matched', get_class($router)));
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
        return $this->_container->get(Uri::class)->getPathInfo();
    }
} 