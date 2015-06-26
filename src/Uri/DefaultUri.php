<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Uri;


use Focus\Request\Request;
use Interop\Container\ContainerInterface;

class DefaultUri implements Uri {

    /**
     * @var string|null PATH_INFO
     */
    private $_pathInfo = null;

    /**
     * @var ContainerInterface
     */
    private $_container;

    public function __construct(ContainerInterface $container) {
        $this->_container = $container;
    }

    /**
     * @return string
     */
    public function getPathInfo() {
        if (is_null($this->_pathInfo)) {
            if (!empty($_SERVER['PATH_INFO'])) {
                $this->_pathInfo = trim($_SERVER['PATH_INFO'], '/');
            } else {
                if (!empty($_SERVER['REQUEST_URI'])) {
                    $res = explode('?', $_SERVER['REQUEST_URI'], 2);
                    if (count($res) == 2) {
                        $this->_pathInfo = trim($res[0]);
                        return $this->_pathInfo;
                    }
                    $this->_pathInfo = $_SERVER['REQUEST_URI'];
                    return $this->_pathInfo;
                }
                $this->_pathInfo = trim($this->_container->get(Request::class)->request('_action_', ''), '/');
            }
        }

        return $this->_pathInfo;
    }
}