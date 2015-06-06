<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/6
 * Time: 13:54
 */
namespace Demo\Models;

use Focus\MVC\Model;

class DemoModel implements Model {
    public function getName() {
        return "Tomcat";
    }

    /**
     * Model初始化
     *
     * @return void
     */
    public function init() {

    }
}