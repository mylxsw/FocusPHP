<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus\Response;


use Interop\Container\ContainerInterface;

class HttpResponse implements Response
{

    private $_buffer  = [];
    private $_headers = [];

    public function __construct(ContainerInterface $container)
    {
    }

    public function header(\string $header, \int $code = 200, \bool $replace = true)
    {
        $this->_headers[] = [$header, $code, $replace];
    }

    public function write(...$data)
    {
        foreach ($data as $_data) {
            $this->_buffer[] = $_data;
        }
    }

    public function output()
    {
        foreach ($this->_headers as $header) {
            header($header[0], $header[2], $header[1]);
        }

        foreach ($this->_buffer as $buffer) {
            echo $buffer;
        }
    }
}