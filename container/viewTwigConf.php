<?php

use Core\Interfaces\ViewInterface;
use Core\Interfaces\ConfigInterface;
use Core\Interfaces\TwigConfigInterface;
use Core\View\Twig\TwigConfigGeneric;
use Core\View\Twig\TwigAdapter;
use Psr\Container\ContainerInterface;
use Twig\TwigFunction;
use Twig\TwigFilter;
use function DI\factory;

return [
    ViewInterface::class => factory(function (ContainerInterface $c) {
        /** @var TwigAdapter $adapter */
        $adapter = $c->get(TwigAdapter::class);
        return $adapter->getView();
    }),
    TwigConfigInterface::class => factory(function (ContainerInterface $c) {
        $twigConfig = new TwigConfigGeneric();
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        if ($config->bool('isProduction')) {
            $twigConfig->setDebug(false)
                    ->setAutoReload(false);
        } else {
            $twigConfig->setDebug(true)
                    ->setAutoReload(true);
        }
        // Add 'trans' filter to use with gettext
        $transFilter = new TwigFilter('trans', function (string $text) {
                    return _($text);
                });
        $twigConfig->addFilter($transFilter);
        // Add '__' function to use with gettext
        $transFunction = new TwigFunction('_', function (string $text) {
                    return _($text);
                });
        $twigConfig->addFunction($transFunction);
        // Configure other settings
        $twigConfig->setAutoEscape('html')
                ->setExtensionsDir($config->stringf('viewExtensions'))
                ->setCacheDir($config->string('loc.templates_compiled') ?? '')
                ->setCharSet('utf-8')
                ->setStrictVariables(true);
        return $twigConfig;
    }),
];
