<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 18:16
 */

namespace Focus\Uri;


use Focus\Request\Request;

class DefaultUri implements Uri {

    /**
     * @var string|null PATH_INFO
     */
    private $_pathInfo = null;

    /**
     * @var Request
     */
    private $_request;

    public function __construct(Request $request) {
        $this->_request = $request;
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
                }
                $this->_pathInfo = trim($this->_request->request('_action_', ''), '/');
            }
        }

        return $this->_pathInfo;
    }
}