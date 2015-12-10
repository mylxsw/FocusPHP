<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Response;


interface Response {

    public function header(\string $header, \int $code = 200, \bool $replace = true);
    public function write(...$data);
    public function output();
}