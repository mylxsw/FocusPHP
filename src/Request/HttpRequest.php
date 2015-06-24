<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;


use Focus\Uri\Uri;
use Focus\Config\Config;
use Focus\Request\Session;
use Interop\Container\ContainerInterface;

class HttpRequest implements Request {

    /**
     * @var ContainerInterface
     */
    private $_container;

    public function __construct(ContainerInterface $container) {
        $this->_container = $container;
    }

    /**
     * @return Uri
     */
    public function uri() {
        return $this->_container->get(Uri::class);
    }

    /**
     * @return Config
     */
    public function config() {
        return $this->_container->get(Config::class);
    }

    public function get( $key, $default = null ) {
        return empty($_GET[$key]) ? $default : $_GET[$key];
    }

    public function post( $key, $default = null ) {
        return empty($_POST[$key]) ? $default : $_POST[$key];
    }

    public function request( $key, $default = null ) {
        return empty($_REQUEST[$key]) ? $default : $_REQUEST[$key];
    }

    public function cookie( $key, $default = null ) {
        return empty($_COOKIE[$key]) ? $default : $_COOKIE[$key];
    }

    /**
     * @return Session
     */
    public function session() {
        return $this->_container->get(Session::class);
    }

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function container() {
        return $this->_container;
    }
}