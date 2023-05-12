<?php

use Core\Interfaces\RouteHttp;
use Core\Interfaces\CodeSnippets;
use Core\Interfaces\Locales;
use Core\Interfaces\ViewTopology;
use Core\Interfaces\WebPage;
use Core\Interfaces\Config;
use Core\Interfaces\Url;
use Core\View\WebPageGeneric;
use Core\View\ViewTopologyGeneric;
use Core\CodeParts\CodeSnippetsDefault;
use Core\JsEnv\Adapters\JsEnvHtml;
use Core\JsEnv\JsEnvDefault;
use Core\Security\Csrf;
use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use function DI\factory;

return [
    ViewTopology::class => factory(function (ContainerInterface $c) {
        /** @var Config $config */
        $config = $c->get(Config::class);
        /** @var Url $url */
        $url = $c->get(Url::class);
        $viewTopology = new ViewTopologyGeneric();
        $viewTopology->setBaseUrl($config->stringf('loc.public'))
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
    WebPage::class => factory(function (ContainerInterface $c) {
        /** @var Locales $locales */
        $locales = $c->get(Locales::class);
        /** @var Config $config */
        $config = $c->get(Config::class);

        $assets = $config->array('assets') ?? ['scripts' => [], 'styles' => []];

        /** @var Url $url */
        $url = $c->get(Url::class);

        /** @var JsEnvHtml $jsEnv */
        $jsEnv = $c->get(JsEnvHtml::class);

        /** @var CodeSnippets $snippers */
        $snippers = $c->get(CodeSnippets::class);

        /** @var RouteHttp $route */
        $route = $c->get(RouteHttp::class);

        /** @var Csrf $csrf */
        $csrf = $c->get(Csrf::class);

        /** @var WebPage $webPage */
        $webPage = new WebPageGeneric($c->get(ViewTopology::class), $assets['scripts'], $assets['styles']);
        $webPage->setAttribute('config', $c->get(Config::class))
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
    JsEnvHtml::class => factory(function (ContainerInterface $c) {
        /** @var Url $url */
        $url = $c->get(Url::class);
        $jsEnvHtml = new JsEnvHtml();
        $jsEnv = new JsEnvDefault($jsEnvHtml);
        $jsEnv->addOwn('api_url', (string) $url . '/api/v1');
        return $jsEnv;
    }),
    CodeSnippets::class => factory(function (ContainerInterface $c) {
        $codeSnippets = new CodeSnippetsDefault($c->get(CacheInterface::class));
        /** @var Config $config */
        $config = $c->get(Config::class);
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
