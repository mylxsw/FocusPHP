<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
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

    const VERSION = '0.1.0';

    /**
     * @var Router
     */
    private $_router;

    /**
     * @var Router 404 Router
     */
    private $_notFoundRouter;

    /**
     * @var Loader
     */
    private $_loader;

    private function __construct() {
        $this->_router = new Router();
        $this->_loader = Loader::instance();
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
        return $this->_loader->getRequest();
    }

    /**
     * @param Request $request
     */
    public function setRequest(Request $request ) {
        $this->_loader->setRequest($request);
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->_loader->getResponse();
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response ) {
        $this->_loader->setResponse($response);
    }

    /**
     * @return Uri
     */
    public function getUri() {
        return $this->getUri();
    }

    /**
     * @param Uri $uri
     */
    public function setUri(Uri $uri ) {
        $this->_loader->setUri($uri);
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