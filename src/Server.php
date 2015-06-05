<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 17:05
 */

namespace Focus;


use Focus\Request\HttpRequest;
use Focus\Request\Request;
use Focus\Response\HttpResponse;
use Focus\Response\Response;
use Focus\Uri\DefaultUri;
use Focus\Uri\Uri;

class Server {

    private static $_instance = null;

    /**
     * @var Router
     */
    private $_router;

    /**
     * @var Request
     */
    private $_request;

    /**
     * @var Response
     */
    private $_response;

    /**
     * @var Uri
     */
    private $_uri;

    private function __construct() {
        $this->_router = new Router();
    }


    /**
     * 初始化服务器对象
     *
     * @return Server
     */
    public static function init() {
        if (empty(self::$_instance)) {
            self::$_instance = new Server();
        }

        return self::$_instance;
    }

    /**
     * 执行请求处理过程
     */
    public function run() {
        $this->_router->setPathInfo($this->getUri()->getPathInfo());
        $this->getRequest()->setUri($this->getUri());

        $matched = $this->_router->parse();
        foreach ($matched as $router) {
            $router->execute($this->getRequest(), $this->getResponse());
            if ($router->isContinue() === false) {
                break;
            }
        }

        $this->getResponse()->output();
    }

    /**
     * 添加路由映射规则
     *
     * @param $router
     * @param $params
     */
    public function map($router, ...$params) {
        $this->_router->add($router, ...$params);
    }

    /**
     * @return Request
     */
    public function getRequest() {
        if (empty($this->_request)) {
            $this->_request = new HttpRequest();
        }
        return $this->_request;
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request ) {
        $this->_request = $request;
    }

    /**
     * @return Response
     */
    public function getResponse() {
        if (empty($this->_response)) {
            $this->_response = new HttpResponse();
        }
        return $this->_response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response ) {
        $this->_response = $response;
    }

    /**
     * @return Uri
     */
    public function getUri() {
        if (empty($this->_uri)) {
            $this->_uri = new DefaultUri($this->getRequest());
        }
        return $this->_uri;
    }

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri ) {
        $this->_uri = $uri;
    }
}