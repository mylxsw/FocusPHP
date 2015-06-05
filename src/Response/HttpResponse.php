<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 18:20
 */

namespace Focus\Response;


class HttpResponse implements Response {

    private $_buffer = [];

    public function header( $header ) {
        // TODO: Implement header() method.
    }

    public function write( ...$data ) {
        $this->_buffer += $data;
    }

    public function output() {
        foreach ($this->_buffer as $buffer) {
            echo $buffer;
        }
    }
}