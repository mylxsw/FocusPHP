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
use Focus\Request\Request;

class Post extends Controller {

    public function showAction( Request $request, \Demo\Models\Post $postModel ) {
        $id   = intval( $request->get( 'id' ) );
        $post = $postModel->getPostById( $id );

        $this->assign( 'post', $post );
        $this->assign( 'parsedown', new \Parsedown() );

        return $this->view( 'post' );
    }

    public function listAction(Request $request, \Demo\Models\Post $postModel) {
        $current = intval($request->get('page', 1));
        $cat = intval($request->get('cat'));

        $posts = $postModel->getPostsInCate($cat, $current);
        $this->assign('posts', $posts['data']);
        $this->assign('page', $posts['page']);
        $this->assign('cat', $cat);

        $this->assign('parsedown', new \Parsedown());
        return $this->view('index');
    }
} 