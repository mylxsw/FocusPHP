<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;


class DefaultSession implements Session{

    public function __construct() {
        session_start();
    }

    public function get( $key, $default = null ) {
        return empty($_SESSION[$key]) ? $default : $_SESSION[$key];
    }

    public function set( $key, $value ) {
        $_SESSION[$key] = $value;
    }

    public function getId() {
        return session_id();
    }

    public function setId( $id ) {
        session_id($id);
    }

    public function clear() {
        session_unset();
    }

    public function destroy() {
        session_destroy();
    }
}