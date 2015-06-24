<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Log;

use Psr\Log\LoggerInterface;
use Focus\Container;

trait LoggerAwareTrait {
    /**
     * @return LoggerInterface
     */
    protected function getLogger() {
        return Container::instance()->get(LoggerInterface::class);
    }
} 