<?php
/**
 * Created by PhpStorm.
 * User: mylxsw
 * Date: 15/6/5
 * Time: 23:44
 */

spl_autoload_register(
    function ($class) {
        $baseNs = 'Demo\\';
        if (strncmp($baseNs, $class, strlen($baseNs)) == 0) {
            $filename = str_replace('\\', '/', __DIR__ . '/' . substr($class, strlen($baseNs)) . '.php');
            if (file_exists($filename)) {
                include $filename;
            }
        }
    },
    true,
    true
);

require __DIR__ . '/../vendor/autoload.php';
