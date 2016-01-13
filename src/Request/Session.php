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

    public function get($key, $default = null);

    public function set($key, $value);

    public function getId();

    public function setId($id);

    public function clear();

    public function destroy();

    public function remove(...$keys);

} 