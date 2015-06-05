<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:55
 */

namespace Demo\Controllers;

use Focus\Request\Request;
use Focus\Response\Response;

class Index {
    public function indexAction(Request $request, Response $response) {
        $response->write("Sorry");
    }
} 