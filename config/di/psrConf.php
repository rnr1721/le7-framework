<?php

use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Interfaces\SessionInterface;
use Core\Interfaces\CookieInterface;
use Core\Interfaces\ConfigInterface;
use Core\Cache\SCFactoryGeneric;
use Core\Session\SessionNative;
use Core\Cookies\CookiesNative;
use Core\Logger\LoggerFactoryGeneric;
use Core\Cookies\CookieConfigDefault;
use Psr\SimpleCache\CacheInterface;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Container\ContainerInterface;
use function DI\factory;
use function DI\get;

return [
    LoggerInterface::class => factory(function (ContainerInterface $c) {
        $factory = new LoggerFactoryGeneric();
        $config = $c->get(ConfigInterface::class);
        $logFile = $config->stringf('loc.var') . DS . 'logs' . DS . 'system.log';
        return $factory->logFile($logFile);
    }),
    CacheInterface::class => factory(function () {
        // File cache by default
        $factory = new SCFactoryGeneric();
        $cachePath = BASE_PATH . DS . 'var' . DS . 'cache';
        return $factory->getFileCache($cachePath);
    }),
    SessionInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $storePath = $config->stringf('loc.var') . DS . 'sessions';
        $session = new SessionNative(false, null, null, $storePath);
        $sessionParams = $config->array('state.session');
        $session->applyParams($sessionParams);
        return $session;
    }),
    CookieInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $cookiesConfig = new CookieConfigDefault($config->array('state.cookies'));
        return new CookiesNative($cookiesConfig);
    }),
    ResponseFactoryInterface::class => get(Psr17Factory::class),
    UriFactoryInterface::class => get(Psr17Factory::class),
    RequestFactoryInterface::class => get(Psr17Factory::class),
    StreamFactoryInterface::class => get(Psr17Factory::class)
];
