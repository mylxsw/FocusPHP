<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;

use Focus\Response\Response;

class Post {

    public function listAction(Response $response, \Demo\Services\Post $postService) {
        $posts = $postService->getAll();
        foreach ($posts as $id => $post) {
            $response->write("<li><span>{$id}</span><span>{$post['title']}</span></li>");
        }
    }
} 