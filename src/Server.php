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
     * Initialize the server object
     *
     * @return Server
     * @throws \ErrorException
     */
    public static function init() {
        if (empty(self::$_instance)) {

            // 环境检测
            if (version_compare(PHP_VERSION, '5.6.0', '<')) {
                throw new \ErrorException('NONSUPPORT_PHP_VERSION');
            }

            self::$_instance = new Server();
        }

        return self::$_instance;
    }

    public function run() {
        $this->registerRouter($this->getNotFoundRouter());

        $matched = $this->_router->parse();
        foreach ($matched as $router) {
            $router->execute($this->getRequest(), $this->getResponse());
        }

        $this->getResponse()->output();
    }

    /**
     * register router
     *
     * @param $router
     * @param $params
     */
    public function registerRouter($router, ...$params) {
        $this->_router->add($router, ...$params);
    }

    /**
     * register exception handler
     *
     * @param callable $handler
     */
    public function registerExceptionHandler($handler) {
        set_exception_handler($handler);
    }

    /**
     * register error handler
     *
     * @param $params      callable
     * @param $error_types int （E_ALL|E_STRICT）
     */
    public function registerErrorHandler($params) {
        set_error_handler(...$params);
    }

    /**
     * register class autoloader
     *
     * @param string $baseDir Root directory of the project
     * @param string $baseNs  Basic namespace
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