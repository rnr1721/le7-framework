<?php

use Twig\TwigFunction;
use Twig\TwigFilter;
use Core\Interfaces\View;
use Core\Interfaces\Config;
use Core\Interfaces\TwigConfig;
use Core\View\Twig\TwigConfigGeneric;
use Core\View\Twig\TwigAdapter;
use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    View::class => factory(function (ContainerInterface $c) {
        /** @var TwigAdapter $adapter */
        $adapter = $c->get(TwigAdapter::class);
        return $adapter->getView();
    }),
    TwigConfig::class => factory(function (ContainerInterface $c) {
        $twigConfig = new TwigConfigGeneric();
        /** @var Config $config */
        $config = $c->get(Config::class);
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
