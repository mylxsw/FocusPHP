<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
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