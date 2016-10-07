<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\Request;

use Focus\Container;

trait RequestAwareTrait
{
    /**
     * @return Request
     */
    public function getRequest()
    {
        return Container::instance()->get(Request::class);
    }
}
