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

class HttpRequest implements Request {

    /**
     * @var Uri
     */
    private $_uri;

    /**
     * @var Session
     */
    private $_session = null;

    /**
     * @return Uri
     */
    public function getUri() {
        return $this->_uri;
    }

    public function setUri( Uri $uri ) {
        $this->_uri = $uri;
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
        if (empty($this->_session)) {
            $this->_session = new DefaultSession();
        }

        return $this->_session;
    }
}