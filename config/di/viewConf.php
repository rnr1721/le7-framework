<?php

use Core\Interfaces\JsEnvironmentInterface;
use Core\Interfaces\RouteHttpInterface;
use Core\Interfaces\CodeSnippetsInterface;
use Core\Interfaces\LocalesInterface;
use Core\Interfaces\ViewTopologyInterface;
use Core\Interfaces\AssetsCollectionInterface;
use Core\Interfaces\WebPageInterface;
use Core\Interfaces\ConfigInterface;
use Core\Interfaces\UrlInterface;
use Core\View\WebPageGeneric;
use Core\View\ViewTopologyGeneric;
use Core\View\AssetsCollectionGeneric;
use Core\CodeParts\CodeSnippetsDefault;
use Core\JsEnv\Adapters\JsEnvHtml;
use Core\JsEnv\JsEnvDefault;
use Core\Security\Csrf;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use function DI\factory;

return [
    ViewTopologyInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        /** @var UrlInterface $url */
        $url = $c->get(UrlInterface::class);
        $viewTopology = new ViewTopologyGeneric();
        $viewTopology->setBaseUrl($url->get())
                ->setCssUrl($url->css())
                ->setFontsUrl($url->fonts())
                ->setImagesUrl($url->images())
                ->setJsUrl($url->js())
                ->setLibsUrl($url->libs())
                ->setThemeUrl($url->theme())
                ->setTemplatePath($config->stringf('loc.templates'))
                ->setTemplatePath($config->string('loc.templates_base'));
        return $viewTopology;
    }),
    WebPageInterface::class => factory(function (ContainerInterface $c) {
        /** @var LocalesInterface $locales */
        $locales = $c->get(LocalesInterface::class);
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);

        /** @var UrlInterface $url */
        $url = $c->get(UrlInterface::class);

        /** @var JsEnvironmentInterface $jsEnv */
        $jsEnv = $c->get(JsEnvironmentInterface::class);

        /** @var CodeSnippetsInterface $snippers */
        $snippers = $c->get(CodeSnippetsInterface::class);

        /** @var RouteHttpInterface $route */
        $route = $c->get(RouteHttpInterface::class);

        /** @var Csrf $csrf */
        $csrf = $c->get(Csrf::class);

        /** @var WebPageInterface $webPage */
        $webPage = new WebPageGeneric(
                $c->get(ViewTopologyInterface::class),
                $c->get(AssetsCollectionInterface::class)
        );
        $webPage->setAttribute('config', $c->get(ConfigInterface::class))
                ->setAttribute('url', $url)
                ->setAttribute('projectName', $config->string('projectName'))
                ->setAttribute('lang', $locales->getCurrentLocaleShortname())
                ->setAttribute('env', $jsEnv->export())
                ->setAttribute('snippets_top', $snippers->get('snippets_top', ''))
                ->setAttribute('snippets_middle', $snippers->get('snippets_middle', ''))
                ->setAttribute('snippets_bottom', $snippers->get('snippets_bottom', ''))
                ->setAttribute('otherLanguages', $url->getLanguageUrlVariants())
                ->setAttribute('route', $route->exportArray())
                ->setAttribute('csrf', $csrf);
        return $webPage;
    }),
    AssetsCollectionInterface::class => factory(function (ContainerInterface $c) {
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $assets = $config->array('assets');
        $collections = $config->array('collections');
        return new AssetsCollectionGeneric(
        $assets['scripts'],
        $assets['styles'],
        $collections
        );
    }),
    JsEnvironmentInterface::class => factory(function (ContainerInterface $c) {
        /** @var LocalesInterface $locales */
        $locales = $c->get(LocalesInterface::class);
        /** @var UrlInterface $url */
        $url = $c->get(UrlInterface::class);
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $jsEnvHtml = new JsEnvHtml();
        $jsEnv = new JsEnvDefault($jsEnvHtml);
        $jsEnv->addOwn('root', (string) $url);
        $jsEnv->addOwn('language', $locales->getCurrentLocaleShortname());
        $jsEnv->addOwn('locales', $locales->getLocalesByName(),false);
        $jsEnv->addMultiple($config->array('jsEnvironment') ?? []);
        return $jsEnv;
    }),
    CodeSnippetsInterface::class => factory(function (ContainerInterface $c) {
        $codeSnippets = new CodeSnippetsDefault($c->get(CacheInterface::class));
        /** @var ConfigInterface $config */
        $config = $c->get(ConfigInterface::class);
        $configPath = $config->string('loc.config');
        $top = $configPath . DS . 'snippets_top.txt';
        $middle = $configPath . DS . 'snippets_middle.txt';
        $bottom = $configPath . DS . 'snippets_bottom.txt';
        $isProduction = $config->bool('isProduction');
        $codeSnippets->register('snippets_top', $top, $isProduction);
        $codeSnippets->register('snippets_middle', $middle, $isProduction);
        $codeSnippets->register('snippets_bottom', $bottom, $isProduction);
        return $codeSnippets;
    })
];
