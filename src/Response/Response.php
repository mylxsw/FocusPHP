<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 17:26
 */

namespace Focus\Response;


interface Response {

    public function header($header);
    public function write(...$data);
    public function output();
} 