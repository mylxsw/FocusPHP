<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Controllers;

use Demo\Libraries\Controller;
use Demo\Models\Category;
use Demo\Models\Post;
use Focus\MVC\SimpleView;
use Focus\Request\Request;

class Index extends Controller {

    public function indexAction(Request $request, Post $postModel) {
        $current = intval($request->get('page', 1));

        $posts = $postModel->getRecentlyPosts($current, 10);
        $this->assign('posts', $posts['data']);
        $this->assign('page', $posts['page']);

        $this->assign('parsedown', new \Parsedown());
        $this->assign('catModel', new Category());
        return $this->view('index');
    }

    public function aboutAction() {
        $this->assign('__navcur__', '走过路过');
        return $this->view('about');
    }

    public function adminAction() {
        header('Location: http://agiledev.sinaapp.com/admin.php');
        exit();
    }
}