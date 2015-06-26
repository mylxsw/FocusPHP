<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Models;


use Demo\Libraries\PDOAwareTrait;
use Focus\MVC\Model;

class Tags implements Model {

    use PDOAwareTrait;
    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {
        // TODO: Implement init() method.
    }

    public function getAllTags() {
        $stat = $this->getPDO()->query('SELECT * FROM `ar_tag` WHERE isvalid=1');
        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }

}