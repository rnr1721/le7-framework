<?php

declare(strict_types=1);

if (!defined('PUBLIC_PATH')) {
    // Prevent to launch not from public folder
    echo 'Please run program from webroot folder'.PHP_EOL;
    exit;
}

// Set microtime for measuring page generation time
$start = microtime(true);

define('BASE_PATH', realpath(dirname(__FILE__)));
$loader = require('vendor/autoload.php');

require (BASE_PATH.'/vendor/rnr1721/le7-core/src/app.php');
