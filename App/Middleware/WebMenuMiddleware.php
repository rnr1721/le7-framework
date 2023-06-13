<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Interfaces\ConfigInterface;
use Core\Interfaces\MenuBuilderInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Get menu items for plugins (bundles)
 */
class WebMenuMiddleware implements MiddlewareInterface
{

    private ConfigInterface $config;
    private MenuBuilderInterface $menuBuilder;

    public function __construct(ConfigInterface $config, MenuBuilderInterface $menuBuilder)
    {
        $this->config = $config;
        $this->menuBuilder = $menuBuilder;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $globals = $this->config->array('globals', []) ?? [];

        $this->menuBuilder->importSource($globals['menu'] ?? []);

        return $handler->handle($request);
    }
}
