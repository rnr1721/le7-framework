<?php

declare(strict_types=1);

namespace le7\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Example implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        /** @var \le7\Core\Instances\RouteHttpInterface $route */
        $route = $request->getAttribute('route');

        // Code here

        return $response;
    }

}
