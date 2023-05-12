<?php

use Core\Interfaces\ErrorHandlerFactory;
use Core\Interfaces\Request;
use Core\Interfaces\Response;
use Core\Interfaces\ResponseEmitter;
use Core\Interfaces\RouteHttp;
use Core\Interfaces\RouteCli;
use Core\Interfaces\Locales;
use Core\Interfaces\MessageFactory;
use Core\Interfaces\MessageCollection;
use Core\Interfaces\MessageCollectionFlash;
use Core\Interfaces\MiddlewareFactory;
use Core\Interfaces\Config;
use Core\Interfaces\Session;
use Core\Interfaces\Cookie;
use Core\Interfaces\Url;
use Core\ErrorHandler\ErrorHandlerCli;
use Core\ErrorHandler\ErrorHandlerHttp;
use Core\RequestDefault;
use Core\ResponseDefault;
use Core\Bag\RouteBag;
use Core\Factories\ErrorHandlerFactoryDefault;
use Core\Locales\LocalesDefault;
use Core\Session\SessionNative;
use Core\Cookies\CookiesNative;
use Core\Cookies\CookieConfigDefault;
use Core\Messages\MessageFactoryGeneric;
use Core\Routing\UrlBuilder;
use Core\Response\ResponseEmitterGeneric;
use Core\Factories\MiddlewareFactoryDefault;
use Core\Config\ConfigFactoryGeneric;
use Psr\SimpleCache\CacheInterface;
use Psr\Container\ContainerInterface;
use function DI\factory;
use function DI\get;
use function DI\autowire;

return [
    Config::class => factory(function (ContainerInterface $c) {
        $cache = $c->get(CacheInterface::class);
        $factory = new ConfigFactoryGeneric($cache);
        return $factory->harvest(BASE_PATH . DS . 'config');
    }),
    MiddlewareFactory::class => autowire(MiddlewareFactoryDefault::class),
    MessageFactory::class => get(MessageFactoryGeneric::class),
    MessageCollection::class => factory(function (ContainerInterface $c) {
        $factory = $c->get(MessageFactory::class);
        return $factory->getMessagesSession();
    }),
    MessageCollectionFlash::class => factory(function (ContainerInterface $c) {
        $factory = $c->get(MessageFactory::class);
        return $factory->getMessagesSession();
    }),
    Session::class => factory(function (ContainerInterface $c) {
        /** @var Config $config */
        $config = $c->get(Config::class);
        $storePath = $config->stringf('loc.var') . DS . 'sessions';
        $session = new SessionNative(false, null, null, $storePath);
        $sessionParams = [
            'lifetime' => 86400,
            'path' => '/',
            'secure' => false,
            'httponly' => true,
            'samesite' => 'Lax'
        ];
        $session->applyParams($sessionParams);
        return $session;
    }),
    Cookie::class => factory(function () {
        $cookiesConfig = new CookieConfigDefault([
            'domain' => '',
            'httpOnly' => true,
            'path' => '/',
            'isSecure' => false,
            'time' => 3600,
            'sameSite' => 'Lax'
        ]);
        return new CookiesNative($cookiesConfig);
    }),
    Locales::class => get(LocalesDefault::class),
    Url::class => get(UrlBuilder::class),
    RouteHttp::class => factory(function (ContainerInterface $c) {
        /** @var RouteBag $bag */
        $bag = $c->get(RouteBag::class);
        return $bag->getRoute();
    }),
    RouteCli::class => factory(function (ContainerInterface $c) {
        /** @var RouteBag $bag */
        $bag = $c->get(RouteBag::class);
        return $bag->getRoute();
    }),
    ResponseEmitter::class => get(ResponseEmitterGeneric::class),
    ErrorHandlerFactory::class => get(ErrorHandlerFactoryDefault::class),
    ErrorHandlerCli::class => factory(function (ContainerInterface $c) {
        /** @var ErrorHandlerFactory $factory */
        $factory = $c->get(ErrorHandlerFactory::class);
        return $factory->getErrorHandlerCli();
    }),
    ErrorHandlerHttp::class => factory(function (ContainerInterface $c) {
        /** @var ErrorHandlerFactory $factory */
        $factory = $c->get(ErrorHandlerFactory::class);
        return $factory->getErrorHandlerHttp($c->get(RouteHttp::class));
    }),
    Response::class => get(ResponseDefault::class),
    Request::class => get(RequestDefault::class)
];
