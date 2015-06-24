<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

namespace Focus\Log;


use Interop\Container\ContainerInterface;
use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger {

    public function __construct(ContainerInterface $container){}

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return null
     */
    public function log( $level, $message, array $context = array() ) {
        echo "<!-- {$message} -->" . PHP_EOL;
    }
}