<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Demo\Libraries;

use Demo\Models\Navigator;
use Focus\MVC\SmpView;

class Controller {

    /**
     * @var SmpView
     */
    protected $view;

    public function __init__() {
        $this->view = new SmpView();
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function assign($key, $value) {
        $this->view->assign($key, $value);
    }

    /**
     * @param string $templateName Template name
     *
     * @return SmpView
     */
    public function view($templateName) {
        $this->view->setTemplate("Views/{$templateName}");
        $this->view->assign('__sidebars__', [
            (new SmpView(null, $this->view->data(), null))->render('Views/_includes/about'),
            (new SmpView(null, $this->view->data(), null))->render('Views/_includes/recently'),
            (new SmpView(null, $this->view->data(), null))->render('Views/_includes/weibo')
        ]);

        $this->view->assign('__nav__', (new SmpView(
            null,
            ['__navigator__'=>(new Navigator())->getNavTrees(0, 'top')],
            null
        ))->render('Views/_includes/navigator', $this->view->data()));

        return $this->view;
    }
} 