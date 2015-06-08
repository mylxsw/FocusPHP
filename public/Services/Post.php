<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Services;

use Focus\MVC\Service;

class Post implements Service {

    /**
     * Initialize the service
     *
     * @return void
     */
    public function init() {
        // TODO: Implement init() method.
    }

    /**
     * @return array
     */
    public function getAll() {
        return [
            ['title' => '测试文章1'],
            ['title' => '测试文章2']
        ];
    }
}