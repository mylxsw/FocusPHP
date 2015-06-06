<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:56
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