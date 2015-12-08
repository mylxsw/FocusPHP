<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus;


use Focus\Exception\HttpNotFoundException;
use Focus\Request\HttpRequest;
use Focus\Request\Request;
use Focus\Response\HttpResponse;
use Focus\Response\Response;
use Focus\Router\NotFoundRouter;
use Focus\Uri\DefaultUri;
use Focus\Uri\Uri;
use Interop\Container\ContainerInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

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
     * @var ContainerInterface
     */
    private $_container;

    private function __construct(ContainerInterface $container) {
        if (is_null($container)) {
            $container = Container::instance();
        }
        $this->_container = $container;
        $this->_router = $container->get(Router::class);
    }

    /**
     * Initialize the server object
     *
     * @param Container $container
     *
     * @return Server
     * @throws \ErrorException
     */
    public static function init(Container $container = null) {
        if (empty(self::$_instance)) {

            // 环境检测
            if (version_compare(PHP_VERSION, '5.6.0', '<')) {
                throw new \ErrorException('NONSUPPORT_PHP_VERSION');
            }
            if (is_null($container)) {
                $container = Container::instance();
            }

            self::$_instance = new Server($container->getContainer());
        }

        return self::$_instance;
    }

    public function run() {
        $matched = $this->_router->parse();
        try {
            if (empty($matched)) {
                throw new HttpNotFoundException('请求的页面不存在');
            }

            foreach ($matched as $router) {
                $router->execute($this->getRequest(), $this->getResponse());
            }
        } catch (HttpNotFoundException $e) {
            $this->getNotFoundRouter()->execute(
                $this->getRequest(),
                $this->getResponse(),
                $e->getMessage()
            );
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
        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG)
            $this->getLogger()->debug('add new router: '
                                  . (is_string($router) ? $router : get_class($router)));
    }

    /**
     * register exception handler
     *
     * @param callable $handler
     */
    public function registerExceptionHandler($handler) {
        set_exception_handler($handler);
        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG)
            $this->getLogger()->debug('register exception handler ok');
    }

    /**
     * register error handler
     *
     * @param callable $params       callable
     * @param int      $error_types （E_ALL|E_STRICT）
     */
    public function registerErrorHandler(...$params) {
        set_error_handler(...$params);
        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG)
            $this->getLogger()->debug('register error handler ok');
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
                        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG)
                            $this->getLogger()->debug('automatic load file ' . $filename);

                        include $filename;

                        if (defined('FOCUS_DEBUG') && FOCUS_DEBUG)
                            $this->getLogger()->debug("file {$filename} loaded");
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
        return $this->_container->get(Request::class);
    }

    /**
     * @return Response
     */
    public function getResponse() {
        return $this->_container->get(Response::class);
    }

    /**
     * @return Uri
     */
    public function getUri() {
        return $this->_container->get(Uri::class);
    }

    /**
     * @return Router\Route
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

    /**
     * @return LoggerInterface
     */
    public function getLogger() {
        return $this->_container->get(LoggerInterface::class);
    }
}