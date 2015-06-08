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

class DefaultRouter implements Route {

    /**
     * @var string 匹配规则
     */
    private $_key;

    /**
     * @var array 规则参数
     */
    private $_params;

    public function __construct($key, ...$params) {
        $this->_key = $key;
        if (empty($params[0])) {
            throw new \InvalidArgumentException("INVALID_ROUTER_ARGS");
        }
        $this->_params = $params;
    }


    /**
     * 判断路由规则是否匹配
     *
     * @param string $pathinfo pathinfo
     * @param int    $index    路由规则索引
     *
     * @return bool
     */
    public function isMatched( $pathinfo, $index ) {
        return $this->_key == $pathinfo;
    }

    /**
     * 处理请求
     *
     * @param Request $request Request Object
     * @param Response $response Response Object
     * @param mixed $params
     *
     * @return void
     */
    public function execute( Request $request, Response $response, ...$params ) {
        if (is_string($this->_params[0])) {
            $response->write(...$this->_params);
        } else if (is_callable($this->_params[0])) {
            $this->_params[0]($request, $response);
        } else {
            throw new \DomainException('INVALID_ROUTER_FUNC');
        }
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