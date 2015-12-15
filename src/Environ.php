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


class Environ
{
    /**
     * Get php.ini configuration
     *
     * @param string     $key
     * @param bool|false $default
     *
     * @return bool|string
     */
    public static function ini($key, $default = false)
    {
        $option = ini_get($key);

        return $option === false ? $default : $option;
    }

}