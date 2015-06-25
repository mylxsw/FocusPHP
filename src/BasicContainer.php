<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Interop\Container\Exception\NotFoundException;

use Psr\Log\LoggerInterface;

use Focus\Exception\ObjectNotFoundException;
use Focus\Request\Request;
use Focus\Request\HttpRequest;
use Focus\Response\Response;
use Focus\Response\HttpResponse;
use Focus\Request\Session;
use Focus\Request\DefaultSession;
use Focus\Uri\Uri;
use Focus\Uri\DefaultUri;
use Focus\Router;
use Focus\Config\Config;
use Focus\Config\ArrayConfig;
use Focus\Log\Logger;

class BasicContainer implements ContainerInterface {

    private $_classes = [];
    private $_lazy_classes = [];
    private static $_systemClasses = [
        Request::class              => HttpRequest::class,
        Response::class             => HttpResponse::class,
        Session::class              => DefaultSession::class,
        Uri::class                  => DefaultUri::class,
        Router::class               => Router::class,
        Config::class               => [ArrayConfig::class, false],
        LoggerInterface::class      => Logger::class
    ];

    public function __construct(...$config_files) {
        foreach ($config_files as $file) {
            if (file_exists($file)) {
                $config = include $file;
                if (empty($config) || !is_array($config)) {
                    continue;
                }

                $this->_lazy_classes = array_merge($this->_lazy_classes, $config);
            }
        }
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get( $id ) {
        if ($this->has($id)) {
            return $this->_classes[$id];
        }

        throw new ObjectNotFoundException("object {$id} not found!");
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has( $id ) {
        $res = isset($this->_classes[$id]);

        if ($res == false && isset($this->_lazy_classes[$id])) {
            if (is_callable($this->_lazy_classes[$id])) {
                $this->_classes[$id] = $this->_lazy_classes[$id]($this);
            } else {
                $this->_classes[$id] = $this->_lazy_classes[$id];
            }

            $res = true;
        }

        if ($res == false && $this->isSystemClass($id)) {
            $res = $this->_loadSystemClass($id);
        }
        return $res;
    }

    /**
     * whether the class name is a system class
     *
     * @param string $id class name
     *
     * @return bool
     */
    public function isSystemClass($id) {
        return isset(self::$_systemClasses[$id]);
    }


    private function _loadSystemClass($id) {
        if (is_array(self::$_systemClasses[$id]) && self::$_systemClasses[$id][1] === false) {
            $object = new self::$_systemClasses[$id];
        } else {
            $object = new self::$_systemClasses[$id]($this);
        }

        $this->_classes[$id] = $object;

        return true;
    }

    /**
     * set an object
     *
     * @param $id
     * @param $object
     *
     * @return BasicContainer
     */
    public function set($id, $object) {
        $this->_classes[$id] = $object;
        return $this;
    }
}