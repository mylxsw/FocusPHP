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

interface Request {


    /**
     * @return Uri
     */
    public function getUri();

    public function setUri(Uri $uri);

    public function get($key, $default = null);

    public function post($key, $default = null);

    public function request($key, $default = null);

    public function cookie($key, $default = null);

    /**
     * @return Session
     */
    public function session();

} 