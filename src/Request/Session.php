<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 22:28
 */

namespace Focus\Request;


interface Session {

    public function get($key, $default = null);

    public function set($key, $value);

    public function getId();

    public function setId($id);

    public function clear();

    public function destroy();

} 