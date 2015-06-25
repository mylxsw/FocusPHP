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

class Navigator implements Model {

    use PDOAwareTrait;
    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {
        // TODO: Implement init() method.
    }

    /**
     * 获取导航树
     *
     * @param $top_id
     * @param $nav_pos
     * @param int $level
     *
     * @return array
     */
    public function getNavTrees($top_id, $nav_pos, $level = 3) {
        $sql = "SELECT * FROM `ar_navigator` WHERE pid = :pid AND pos = :pos AND isvalid=1 ORDER BY sort DESC";
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute([
            ':pid'      => $top_id,
            ':pos'      => $nav_pos
        ]);

        $menu_list = $stat->fetchAll(\PDO::FETCH_ASSOC);
        $level--;

        $menus = [];
        if ($level > 0) {
            foreach ($menu_list as $k => $v) {
                array_push($menus, $v);
                $res = $this->getNavTrees($v['id'], $nav_pos, $level);
                if (count($res) > 0) {
                    $menus[$k]['sub'] = $res;
                }
            }
        }

        return $menus;
    }
}