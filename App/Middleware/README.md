# Place to put your own middlewares

You can configure middlewares in ./config/middlewares.php
Middleware that run controller and action is
Core\Middleware\ControllerRunMiddleware

Example of PSR middleware with DI injected route:

```php
<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Interfaces\RouteHttpInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Example implements MiddlewareInterface
{

    public RouteHttpInterface $route;


    public function __construct(RouteHttpInterface $route)
    {
        $this->route = $route;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        
        return $response;
    }

}
```

Example of clean middleware:

```php
<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Example implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);

        return $response;
    }

}
```
