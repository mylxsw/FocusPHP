<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;


use Interop\Container\ContainerInterface;

class DefaultSession implements Session{

    public function __construct(ContainerInterface $container) {
        session_start();
    }

    public function get(\string $key, $default = null ) {
        return empty($_SESSION[$key]) ? $default : $_SESSION[$key];
    }

    public function set(\string $key, $value ) {
        $_SESSION[$key] = $value;
    }

    public function getId(): \string {
        return session_id();
    }

    public function setId(\string $id ) {
        session_id($id);
    }

    public function clear() {
        session_unset();
    }

    public function destroy() {
        session_destroy();
    }
}