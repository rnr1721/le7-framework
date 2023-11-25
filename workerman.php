<?php

declare(strict_types=1);

namespace App;

use Core\Topology;
use Core\InitHttp;
use Workerman\Worker;
use App\Classes\Factories\ContainerFactoryPhpDi;
use Workerman\Protocols\Http\Request;
use Workerman\Protocols\Http\Response;
use Nyholm\Psr7\Factory\Psr17Factory;
use Workerman\Connection\TcpConnection;

error_reporting(E_ALL);
ini_set('display_errors', '1');

$listen = 'http://127.0.0.1:8080';

define('BASE_PATH', realpath(dirname(__FILE__)));

define('DS', DIRECTORY_SEPARATOR);

$diCompiledPath = BASE_PATH . DS . 'var' . DS . 'containers';
$diConfig = BASE_PATH . DS . 'container';

$loader = require('vendor' . DS . 'autoload.php');

$topology = new Topology(BASE_PATH . DS . 'public', BASE_PATH);

if (!class_exists(Worker::class)) {
    echo 'Please install workerman via composer';
    exit;
}

$worker = new Worker($listen);

$worker->count = 4;

$worker->onMessage = function (TcpConnection $connection, Request $workermanRequest) use ($diConfig, $diCompiledPath, $topology) {

    $containerFactory = new ContainerFactoryPhpDi($diConfig, $diCompiledPath);

    $psr17Factory = new Psr17Factory();

    $request = $psr17Factory->createServerRequest(
            $workermanRequest->method(),
            $workermanRequest->uri(),
            $workermanRequest->header(),
            $workermanRequest->rawBody()
    );

    $app = new InitHttp($containerFactory, $topology);

    $response = $app->handle($request);

    // Send the response back to the client
    $workermanResponse = new Response();
    $workermanResponse->withHeaders($response->getHeaders());
    $workermanResponse->withStatus($response->getStatusCode(), $response->getReasonPhrase());
    $workermanResponse->withBody((string) $response->getBody());
    $connection->send($workermanResponse);
};

Worker::runAll();
