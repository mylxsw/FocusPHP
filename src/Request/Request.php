<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Request;



use Focus\Uri\Uri;
use Focus\Config\Config;
use Interop\Container\ContainerInterface;

interface Request {


    /**
     * @return Uri
     */
    public function uri(): Uri;

    /**
     * @return Config
     */
    public function config(): Config;

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function get(\string $key, $default = null);

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function post(\string $key, $default = null);

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function request(\string $key, $default = null);

    /**
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function cookie(\string $key, $default = null);

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function container(): ContainerInterface;

    /**
     * @return Session
     */
    public function session(): Session;

} 