<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:55
 */

namespace Demo\Controllers;

use Demo\Models\DemoModel;
use Focus\Request\Request;
use Focus\Response\Response;

class Index {
    public function indexAction(Request $request, Response $response, DemoModel $demoModel) {
        $response->write("This is index controller and indexAction method, and My name is " . $demoModel->getName());
    }
} 