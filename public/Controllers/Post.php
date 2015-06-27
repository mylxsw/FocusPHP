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
use Focus\Request\Request;

class Post extends Controller {

    public function showAction( Request $request, \Demo\Models\Post $postModel ) {
        $id   = intval( $request->get( 'id' ) );
        $post = $postModel->getPostById( $id );

        $this->assign( 'post', $post );
        $this->assign( 'parsedown', new \Parsedown() );
        $this->assign('catModel', new Category());

        return $this->view( 'post' );
    }

    public function listAction(Request $request, \Demo\Models\Post $postModel) {
        $current = intval($request->get('page', 1));
        $cat = intval($request->get('cat'));

        $posts = $postModel->getPostsInCate($cat, $current);
        $this->assign('posts', $posts['data']);
        $this->assign('page', $posts['page']);
        $this->assign('__cat__', $cat);
        $this->assign('__navcur__', '技不压身');

        $this->assign('parsedown', new \Parsedown());
        $this->assign('catModel', new Category());
        return $this->view('index');
    }
    
    public function tagAction(Request $request, \Demo\Models\Post $postModel, \Demo\Models\Tags $tagModel) {
        $tagName = $request->get('tag');
        $current = intval($request->get('page', 1));
        
        $tag = $tagModel->getTagByName($tagName);
        $posts = $postModel->getPostsByTag($tag['id'], $current);

        $this->assign('posts', $posts['data']);
        $this->assign('page', $posts['page']);
        $this->assign('__tag__', $tag);
        $this->assign('__navcur__', '技不压身');
        
        $this->assign('parsedown', new \Parsedown());
        $this->assign('catModel', new Category());
        return $this->view('index');
    }
} 