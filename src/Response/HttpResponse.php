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
    private $_headers = [];

    public function header( $header ) {
        $this->_headers[] = $header;
    }

    public function write( ...$data ) {
        $this->_buffer += $data;
    }

    public function output() {
        foreach ($this->_headers as $header) {
            header($header);
        }

        foreach ($this->_buffer as $buffer) {
            echo $buffer;
        }
    }
}