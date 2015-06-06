<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;


use Focus\Request\Request;
use Focus\Response\Response;

class User {

    public function indexAction(Request $request, Response $response) {
        $response->write("Welcome , " . $request->get('username', 'anonymous'));
    }

    public function helloAction(Request $request, Response $response) {
        $response->write('Hello!');
    }
} 