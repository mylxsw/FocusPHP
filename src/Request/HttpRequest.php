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
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_HEAD = 'HEAD';
    const HTTP_PUT = 'PUT';
    const HTTP_DELETE = 'DELETE';
    const HTTP_OPTIONS = 'OPTIONS';

    /**
     * @var ContainerInterface
     */
    private $_container;
    private $_needEscape = false;

    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->_needEscape = !get_magic_quotes_gpc();
    }

    /**
     * @return Uri
     */
    public function uri()
    {
        return $this->_container->get(Uri::class);
    }

    /**
     * @return Config
     */
    public function config()
    {
        return $this->_container->get(Config::class);
    }

    public function get($key, $default = null)
    {
        if (!isset($_GET[$key])) {
            return $default;
        }

        return is_null($_GET[$key]) ? $default : $this->_escape($_GET[$key]);
    }

    public function post($key, $default = null)
    {
        if (!isset($_POST[$key])) {
            return $default;
        }

        return is_null($_POST[$key]) ? $default : $this->_escape($_POST[$key]);
    }

    public function request($key, $default = null)
    {
        if (!isset($_REQUEST[$key])) {
            return $default;
        }

        return is_null($_REQUEST[$key]) ? $default
            : $this->_escape($_REQUEST[$key]);
    }

    public function cookie($key, $default = null)
    {
        if (!isset($_COOKIE[$key])) {
            return $default;
        }

        return is_null($_COOKIE[$key]) ? $default
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
            return array_map(function ($n) {
                return addslashes($n);
            }, $value);
        }
        return addslashes($value);
    }

    /**
     * @return Session
     */
    public function session()
    {
        return $this->_container->get(Session::class);
    }

    /**
     * @return \Interop\Container\ContainerInterface
     */
    public function container()
    {
        return $this->_container;
    }

    /**
     * 判断是否是XMLHttpRequest
     *
     * @return bool
     */
    public function isXMLHttpRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
        && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHTTPREQUEST';
    }

    /**
     * Get request method
     *
     * @return string
     */
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 页面跳转
     *
     * @param string $url
     * @param bool|true $temporary 暂时or永久
     *
     * @return string
     */
    public function redirect($url, $temporary = true)
    {
        header("Location: {$url}", true, $temporary ? 302 : 301);
        return '';
    }

    /**
     * Get Http input stream
     *
     * @return string
     */
    public function getInputStream()
    {
        return file_get_contents('php://input');
    }
}