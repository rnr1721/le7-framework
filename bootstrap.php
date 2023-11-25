<?php

declare(strict_types=1);

use Nyholm\Psr7Server\ServerRequestCreator;
use Core\Topology;
use Core\InitHttp;
use Core\InitCli;
use Core\Factories\ContainerFactoryPhpDi;

if (!defined('PUBLIC_PATH')) {
    // Prevent to launch not from public folder
    echo 'Please run program from webroot folder' . PHP_EOL;
    exit;
}

// Set microtime for measuring page generation time
$start = microtime(true);

define('BASE_PATH', realpath(dirname(__FILE__)));

define('DS', DIRECTORY_SEPARATOR);

$diCompiledPath = BASE_PATH . DS . 'var' . DS . 'containers';
$diConfig = BASE_PATH . DS . 'container';

$loader = require('vendor' . DS . 'autoload.php');

$topology = new Topology(PUBLIC_PATH, BASE_PATH);

$containerFactory = new ContainerFactoryPhpDi($diConfig, $diCompiledPath);

if (php_sapi_name() === 'cli') {
    $init = new InitCli($containerFactory, $topology);
    $init->run();
} else {
    $init = new InitHttp($containerFactory, $topology);
    $factory = new Nyholm\Psr7\Factory\Psr17Factory();
    $creator = new ServerRequestCreator(
            $factory, // ServerRequestFactory
            $factory, // UriFactory
            $factory, // UploadedFileFactory
            $factory  // StreamFactory
    );
    $request = $creator->fromGlobals();
    $response = $init->run($request);
}
