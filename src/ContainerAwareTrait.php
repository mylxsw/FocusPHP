<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus;


trait ContainerAwareTrait {

    /**
     * @return Container
     */
    public function getContainer() {
        return Container::instance();
    }
} 