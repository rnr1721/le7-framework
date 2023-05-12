<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Interfaces\Config;
use Core\Interfaces\ListenerProvider;
use Core\Bag\RequestBag;
use Core\Cache\SCFactoryGeneric;
use Core\Logger\LoggerFactoryGeneric;
use Core\EventDispatcher\Providers\ListenerProviderDefault;
use Core\EventDispatcher\EventDispatcher;
use Psr\SimpleCache\CacheInterface;
use Psr\Log\LoggerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use function DI\factory;
use function DI\get;

return [
    ServerRequestInterface::class => factory(function (ContainerInterface $c) {
        /** @var RequestBag $requestBag */
        $requestBag = $c->get(RequestBag::class);
        return $requestBag->getServerRequest();
    }),
    ResponseFactoryInterface::class => get(Psr17Factory::class),
    ResponseInterface::class => factory(function (ContainerInterface $c) {
        /** @var ResponseFactoryInterface $factory */
        $factory = $c->get(ResponseFactoryInterface::class);
        return $factory->createResponse(404);
    }),
    EventDispatcherInterface::class => get(EventDispatcher::class),
    ListenerProvider::class => factory(function (ContainerInterface $c) {
        /** @var Config $config */
        $config = $c->get(Config::class);
        $events = $config->array('events') ?? [];
        $listeners = new ListenerProviderDefault();
        foreach ($events as $key => $eventValue) {
            $listeners->on($eventValue[0], $eventValue[1], $key);
        }
        return $listeners;
    }),
    LoggerInterface::class => factory(function (ContainerInterface $c) {
        $factory = new LoggerFactoryGeneric();
        $config = $c->get(Config::class);
        $logFile = $config->stringf('loc.var') . DS . 'logs' . DS . 'system.log';
        return $factory->logFile($logFile);
    }),
    CacheInterface::class => factory(function () {
        // File cache by default
        $factory = new SCFactoryGeneric();
        $cachePath = BASE_PATH . DS . 'var' . DS . 'cache';
        return $factory->getFileCache($cachePath);
    })
];
