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
use Focus\Router\NotFoundRouter;
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

    /**
     * @var Router 404 Router
     */
    private $_notFoundRouter;

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

            // 环境检测
            if (version_compare(PHP_VERSION, '5.6.0', '<')) {
                throw new \RuntimeException('PHP版本过低，请升级为PHP 5.6.0以后版本');
            }

            self::$_instance = new Server();
        }

        return self::$_instance;
    }

    /**
     * 执行请求处理过程
     */
    public function run() {
        $this->registerRouter($this->getNotFoundRouter());

        $this->_router->setPathInfo($this->getUri()->getPathInfo());
        $this->getRequest()->setUri($this->getUri());

        $matched = $this->_router->parse();
        foreach ($matched as $router) {
            $router->execute($this->getRequest(), $this->getResponse());
        }

        $this->getResponse()->output();
    }

    /**
     * 添加路由映射规则
     *
     * @param $router
     * @param $params
     */
    public function registerRouter($router, ...$params) {
        $this->_router->add($router, ...$params);
    }

    /**
     * 注册自动类加载器
     *
     * @param string $baseDir 项目根目录
     * @param string $baseNs  根目录的命名空间
     */
    public function registerAutoloader($baseDir, $baseNs) {
        $baseNs = $baseNs[strlen($baseNs) - 1] == '\\' ? $baseNs : "{$baseNs}\\";
        $baseDir = rtrim($baseDir, '/');

        spl_autoload_register(
            function ($class) use ($baseDir, $baseNs) {
                if (strncmp($baseNs, $class, strlen($baseNs)) == 0) {
                    $filename = str_replace(
                        '\\',
                        '/',
                        $baseDir . '/' . substr($class, strlen($baseNs)) . '.php'
                    );
                    if (file_exists($filename)) {
                        include $filename;
                    }
                }
            },
            true,
            false
        );
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

    /**
     * @return Router
     */
    public function getNotFoundRouter() {
        if (empty($this->_notFoundRouter)) {
            $this->_notFoundRouter = new NotFoundRouter();
        }
        return $this->_notFoundRouter;
    }

    /**
     * @param NotFoundRouter $notFoundRouter
     */
    public function setNotFoundRouter(NotFoundRouter $notFoundRouter ) {
        $this->_notFoundRouter = $notFoundRouter;
    }


}