<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus\Request;


use Focus\Uri\Uri;
use Focus\Config\Config;
use Focus\Request\Session;
use Interop\Container\ContainerInterface;

class HttpRequest implements Request
{

    /**
     * @var ContainerInterface
     */
    private $_container;
    private $_needEscape = false;

    public function __construct(ContainerInterface $container)
    {
        $this->_container  = $container;
        $this->_needEscape = !get_magic_quotes_gpc();
    }

    /**
     * @return Uri
     */
    public function uri(): Uri
    {
        return $this->_container->get(Uri::class);
    }

    /**
     * @return Config
     */
    public function config(): Config
    {
        return $this->_container->get(Config::class);
    }

    public function get(\string $key, $default = null)
    {
        return empty($_GET[$key]) ? $default : $this->_escape($_GET[$key]);
    }

    public function post(\string $key, $default = null)
    {
        return empty($_POST[$key]) ? $default : $this->_escape($_POST[$key]);
    }

    public function request(\string $key, $default = null)
    {
        return empty($_REQUEST[$key]) ? $default
            : $this->_escape($_REQUEST[$key]);
    }

    public function cookie(\string $key, $default = null)
    {
        return empty($_COOKIE[$key]) ? $default
            : $this->_escape($_COOKIE[$key]);
    }

    /**
     * escape string value
     *
     * @param $value
     *
     * @return string
     */
    private function _escape($value)
    {
        if (!$this->_needEscape) {
            return $value;
        }

        if (is_array($value)) {
            return array_map(function($n) {
                return addslashes($n);
            }, $value);
        }
        return addslashes($value);
    }

    /**
     * @return Session
     */
    public function session(): Session
    {
        return $this->_container->get(Session::class);
    }

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function container(): ContainerInterface
    {
        return $this->_container;
    }

    /**
     * 判断是否是XMLHttpRequest
     *
     * @return bool
     */
    public function isXMLHttpRequest(): \bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST';
    }

    /**
     * 页面跳转
     *
     * @param string    $url
     * @param bool|true $temporary 暂时or永久
     *
     * @return string
     */
    public function redirect($url, $temporary = true): \string
    {
        header("Location: {$url}", true, $temporary ? 302 : 301);
        return '';
    }
}