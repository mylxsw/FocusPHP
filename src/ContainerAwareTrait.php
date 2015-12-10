<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */

namespace Focus;


trait ContainerAwareTrait
{

    /**
     * @return Container
     */
    public function getContainer()
    {
        return Container::instance();
    }

    public function __call($name, $arguments)
    {
        if (strlen($name) > 3 && strncmp($name, 'get', 3) === 0) {
            return $this->getContainer()->get(substr($name, 3));
        }

        return '';
    }
} 