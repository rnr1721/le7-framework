<?php

use Core\Interfaces\ViewInterface;
use Core\Interfaces\ConfigInterface;
use Core\Interfaces\SmartyConfigInterface;
use Core\View\Smarty\SmartyConfigGeneric;
use Core\View\Smarty\SmartyAdapter;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    ViewInterface::class => factory(function (ContainerInterface $c) {
        $adapter = $c->get(SmartyAdapter::class);
        return $adapter->getView();
    }),
    SmartyConfigInterface::class => factory(function (ContainerInterface $c) {
        $smartyConfig = new SmartyConfigGeneric();
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $smartyConfig->setPluginsDir($config->stringf('viewExtensions'))
                ->setCompiledDir($config->string('loc.templates_compiled') ?? '');
        return $smartyConfig;
    }),
];
