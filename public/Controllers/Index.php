<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;

use Demo\Models\DemoModel;
use Focus\MVC\SimpleView;
use Focus\MVC\SmpJsonView;
use Focus\MVC\SmpView;
use Focus\Request\Request;
use Focus\Response\Response;

class Index {
    public function indexAction(Request $request, Response $response) {

        return new SmpView('Views/index', []);
    }

    public function jsonAction(Request $request, Response $response, SmpJsonView $json) {
        $json->assign('status', 1);
        $json->assign('message', '操作成功');
        return $json;
    }
} 