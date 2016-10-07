<?php
/**
 * FocusPHP.
 *
 * @link      http://aicode.cc/
 *
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the
 *            LICENSE file)
 */
ini_set('display_errors', 1);

if (!defined('AUTOLOAD_PATH')) {
    define('AUTOLOAD_PATH', './vendor/autoload.php');
}

$loader = include __DIR__.'/../'.AUTOLOAD_PATH;
$loader->add('Focus', __DIR__);
