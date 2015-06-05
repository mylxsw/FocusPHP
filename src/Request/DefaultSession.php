<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 22:29
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