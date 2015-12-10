<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;


interface Session {

    public function get(\string $key, $default = null);

    public function set(\string $key, $value);

    public function getId(): \string;

    public function setId(\string $id);

    public function clear();

    public function destroy();

} 