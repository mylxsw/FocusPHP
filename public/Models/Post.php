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
use Demo\Libraries\Tools;
use Focus\Config\ConfigAwareTrait;
use Focus\ContainerAwareTrait;
use Focus\MVC\Model;

class Post implements Model {

    use ConfigAwareTrait,
        ContainerAwareTrait,
        PDOAwareTrait;

    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {}

    /**
     * 查询最近发布的帖子
     *
     * @param int $current 当前页码
     * @param int $count   每页显示的数目
     *
     * @return ['data'=> ..., 'page'=>[total, offset, count, page_nums, current]]
     */
    public function getRecentlyPosts($current, $count = 10) {
        $total = $this->getPostCount();
        list($total, $offset, $count, $page_nums, $current)
            = Tools::createPageInfo($total, $count, $current);

        $sql = "SELECT * FROM `ar_article`  ORDER BY `publish_date` DESC LIMIT {$offset}, {$count}";
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute();

        return [
            'data'  => $stat->fetchAll(\PDO::FETCH_ASSOC),
            'page'  => [
                'total'     => $total,
                'offset'    => $offset,
                'count'     => $count,
                'page_nums' => $page_nums,
                'current'   => $current
            ]
        ];
    }

    /**
     * 查询帖子
     *
     * @param int $cat     分类ID
     * @param int $current 当前页码
     * @param int $count   每页显示的数目
     *
     * @return ['data'=> ..., 'page'=>[total, offset, count, page_nums, current]]
     */
    public function getPostsInCate($cat, $current, $count = 10) {
        $where = 'id IN (SELECT re.article_id FROM ar_article_category re WHERE re.category_id = :cat)';
        $params = [':cat' => $cat];
        $total = $this->getPostCount($where, $params);

        list($total, $offset, $count, $page_nums, $current)
            = Tools::createPageInfo($total, $count, $current);

        $sql = "SELECT * FROM `ar_article` WHERE {$where} ORDER BY `publish_date` DESC LIMIT {$offset}, {$count}";
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute($params);

        return [
            'data'  => $stat->fetchAll(\PDO::FETCH_ASSOC),
            'page'  => [
                'total'     => $total,
                'offset'    => $offset,
                'count'     => $count,
                'page_nums' => $page_nums,
                'current'   => $current
            ]
        ];
    }
    
    public function getPostsByTag($tagId, $current, $count = 10) {
        $where = 'id IN (SELECT re.article_id FROM ar_article_tag re WHERE re.tag_id=:tag)';
        $params = [':tag' => $tagId];
        $total = $this->getPostCount($where, $params);

        list($total, $offset, $count, $page_nums, $current)
            = Tools::createPageInfo($total, $count, $current);

        $sql = "SELECT * FROM `ar_article` WHERE {$where} ORDER BY `publish_date` DESC LIMIT {$offset}, {$count}";
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute($params);

        return [
            'data'  => $stat->fetchAll(\PDO::FETCH_ASSOC),
            'page'  => [
                'total'     => $total,
                'offset'    => $offset,
                'count'     => $count,
                'page_nums' => $page_nums,
                'current'   => $current
            ]
        ];  
    
    }

    /**
     * 获取所有帖子数目
     *
     * @param string $where
     * @param array $params
     *
     * @return mixed
     */
    public function getPostCount($where = '', $params = []) {
        $stat = $this->getPDO()->prepare('SELECT count(*) as count FROM `ar_article` '
                                 . (empty($where) ? '' : " WHERE {$where}"));
        $stat->execute($params);
        $res = $stat->fetch(\PDO::FETCH_ASSOC);

        return $res['count'];
    }

    /**
     * 获取
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getPostById($id) {
        $stat = $this->getPDO()->prepare("SELECT * FROM `ar_article` WHERE id = :id");
        $stat->execute([':id'=> intval($id)]);

        $res = $stat->fetch(\PDO::FETCH_ASSOC);
        return $res;
    }
}