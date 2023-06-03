<?php

use Core\Interfaces\ApiRequestInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Core\Factories\HttpClientFactory;
use Core\Interfaces\HttpClientFactoryInterface;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    ApiRequestInterface::class => factory(function (ContainerInterface $c) {
        /** @var HttpClientFactoryInterface $factory */
        $factory = $c->get(HttpClientFactoryInterface::class);
        return $factory->getApiRequest();
    }),
    HttpClientFactoryInterface::class => factory(function (ContainerInterface $c) {
        /** @var Psr17Factory $psr17factory */
        $psr17factory = $c->get(Psr17Factory::class);
        /** @var HttpClientFactoryInterface $factory */
        $factory = new HttpClientFactory(
        $psr17factory,
        $psr17factory,
        $psr17factory,
        $psr17factory
        );
        $factory->setDefaultHttpClient('php');
        return $factory;
    })
];
