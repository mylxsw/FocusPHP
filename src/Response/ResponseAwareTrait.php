<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */
namespace Focus\Response;

use Focus\Container;

trait ResponseAwareTrait
{
    /**
     * @return Response
     */
    public function getResponse()
    {
        return Container::instance()->get(Response::class);
    }
}
