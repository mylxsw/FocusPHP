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

class Category implements Model {

    use PDOAwareTrait;
    /**
     * Initialize the model
     *
     * @return void
     */
    public function init() {
        // TODO: Implement init() method.
    }

    public function getCategoriesByArticleId($articleId) {
        $sql = 'SELECT * FROM `ar_category` WHERE id in (SELECT category_id FROM `ar_article_category` WHERE article_id=:article_id)';
        $stat = $this->getPDO()->prepare($sql);
        $stat->execute(['article_id' => $articleId]);

        return $stat->fetchAll(\PDO::FETCH_ASSOC);
    }
}