<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 17:26
 */

namespace Focus\Request;



use Focus\Uri\Uri;

interface Request {


    /**
     * @return Uri
     */
    public function getUri();

    public function setUri(Uri $uri);

    public function get($key, $default = null);

    public function post($key, $default = null);

    public function request($key, $default = null);

    public function cookie($key, $default = null);

    /**
     * @return Session
     */
    public function session();

} 