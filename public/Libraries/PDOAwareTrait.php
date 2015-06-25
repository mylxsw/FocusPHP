<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;


use Focus\Container;

trait PDOAwareTrait {

    /**
     * @return \PDO
     */
    public function getPDO() {
        return Container::instance()->get(\PDO::class);
    }
} 