<?php

use Core\Interfaces\View;
use Core\Interfaces\Config;
use Core\Interfaces\SmartyConfig;
use Core\View\Smarty\SmartyConfigGeneric;
use Core\View\Smarty\SmartyAdapter;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    View::class => factory(function (ContainerInterface $c) {
        $adapter = $c->get(SmartyAdapter::class);
        return $adapter->getView();
    }),
    SmartyConfig::class => factory(function (ContainerInterface $c) {
        $smartyConfig = new SmartyConfigGeneric();
        /** @var Config $config */
        $config = $c->get(Config::class);
        $smartyConfig->setPluginsDir($config->stringf('viewExtensions'))
                ->setCompiledDir($config->string('loc.templates_compiled') ?? '');
        return $smartyConfig;
    }),
];
