<?php

return [
    'web' => [
        'wpContent' => 'le7\Core\Middleware\System\WebpageContentMiddleware',
        'auth' => 'le7\Core\Middleware\System\UserAuthMiddleware',
        'events' => 'le7\Core\Middleware\System\EventsMiddleware',
        'errors' => 'le7\Core\Middleware\System\ErrorHandlerWebMiddleware',
        'code' => 'le7\Core\Middleware\System\ResponseCodeMiddleware',
        'locales' => 'le7\Core\Middleware\System\LocalesMiddleware',
        'cache' => 'le7\Core\Middleware\System\CacheMiddleware',
        'cookies' => 'le7\Core\Middleware\System\CookiesSetupMiddleware',
    ],
    'api' => [
        'auth' => 'le7\Core\Middleware\System\UserAuthMiddleware',
        'events' => 'le7\Core\Middleware\System\EventsMiddleware',
        'errors' => 'le7\Core\Middleware\System\ErrorHandlerApiMiddleware',
        'code' => 'le7\Core\Middleware\System\ResponseCodeMiddleware',
        'locales' => 'le7\Core\Middleware\System\LocalesMiddleware',
        'method' => 'le7\Core\Middleware\System\ApiMethodMiddleware',
    ]
];
