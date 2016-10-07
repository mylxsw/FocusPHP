<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\Request;

use Focus\Config\Config;
use Focus\Uri\Uri;

interface Request
{
    /**
     * @return Uri
     */
    public function uri();

    /**
     * @return Config
     */
    public function config();

    public function get($key, $default = null);

    public function post($key, $default = null);

    public function request($key, $default = null);

    public function cookie($key, $default = null);

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function container();

    /**
     * @return Session
     */
    public function session();
}
