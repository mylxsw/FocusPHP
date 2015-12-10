<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Config;


use Focus\Container;

trait ConfigAwareTrait {

    /**
     * 获取Config实例
     *
     * @return Config
     */
    public function getConfig(): Config {
        return Container::instance()->get(Config::class);
    }
} 