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
use Focus\Request\Request;
use Focus\Response\Response;

class Index {
    public function indexAction(Request $request, Response $response) {

        return new SimpleView('Views/index', []);
    }
} 