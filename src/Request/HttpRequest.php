<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;


use Focus\Loader;
use Focus\Uri\Uri;

class HttpRequest implements Request {

    /**
     * @var Session
     */
    private $_session = null;

    /**
     * @return Uri
     */
    public function uri() {
        return Loader::instance()->getUri();
    }

    /**
     * @return \Focus\Config\Config
     */
    public function config() {
        return Loader::instance()->getConfig();
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
        return Loader::instance()->getSession();
    }
}