<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
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