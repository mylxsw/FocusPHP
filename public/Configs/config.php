<?php
/**
 * FocusPHP
 *
 * @link      http://aicode.cc/
 * @copyright 管宜尧 <mylxsw@aicode.cc>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT (see the LICENSE file)
 */

$config = [

    'db.driver'    => 'mysql',
    'db.host'      => '127.0.0.1',
    'db.port'      => 3306,
    'db.dbname'    => 'focusphp',
    'db.user'      => 'root',
    'db.password'  => '',
    'db.charset'   => 'utf8',

];

if (defined('SAE_ACCESSKEY')) {
    $config['db.host'] = 'w.rdc.sae.sina.com.cn';
    $config['db.dbname'] = 'app_agiledev';
    $config['db.user'] = '44yw14kx0x';
    $config['db.password'] = 'wiykwk1hhz3m531zixmhw3i2w1341klzxhyi1x5k';
    $config['db.port'] = 3307;
}

return $config;