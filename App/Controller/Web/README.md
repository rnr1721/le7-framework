# Default folder for web controllers
Put your controllers for Web here.
All Web and Api controller actions must return PSR ResponseInterface.

## Dependency injection

All controllers allow Dependency Injection in constructor or in action methods

For example, DI in constructor:

```php
<?php

namespace App\Controller\Web;

use Core\Interfaces\WebPageInterface;
use Core\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    public WebPageInterface $webPage;
    public ViewInterface $view;

    public function __construct(ViewInterface $view, WebPageInterface $webPage)
    {
        $this->webPage = $webPage;
        $this->view = $view;
    }

    public function indexAction(): ResponseInterface
    {
        $this->webPage->setPageTitle('Start Page');
        $this->view->assign('content','mainpage.twig');
        return $this->view->render('layout.twig', []);
    }

    public function contactsAction(): ResponseInterface
    {
        return $this->view->render('contacts');
    }

}
```

DI in method

```php
<?php

namespace App\Controller\Web;

use Core\Interfaces\WebPageInterface;
use Core\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    public function indexAction(ViewInterface $view, WebPageInterface $webPage): ResponseInterface
    {
        $webPage->setPageTitle('Start Page');
        $view->assign('content','mainpage.twig');
        return $view->render('layout.twig', []);
    }

}
```

Another example - DI in method

```php
<?php

namespace App\Controller\Web;

use Core\Interfaces\HttpOutputInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    public function indexAction(HttpOutputInterface $response): ResponseInterface
    {

        $data = [
            'one' => 1,
            'two' => 2
        ];

        $response->toJson()->emit($data, 200);
    }

}
```

I you are using PHP-DI, you can use PHP-DI to inject in property:

```php
<?php

namespace App\Controller\Web;

use DI\Attribute\Inject;
use Core\Interfaces\HttpOutputInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    #[Inject]
    public HttpOutputInterface $response;

    public function indexAction(): ResponseInterface
    {

        $data = [
            'one' => 1,
            'two' => 2
        ];

        $this->response->toJson()->emit($data, 200);
    }

}
```

## Controller parameters

### Turn on or off csrf security to route:

Csrf protection turned on by default. But for some routes you can turn off this:

```php
<?php

namespace App\Controller\Web;

use DI\Attribute\Inject;
use Core\Attributes\Params;
use Core\Interfaces\HttpOutputInterface;
use Psr\Http\Message\ResponseInterface;

class IndexController
{

    #[Inject]
    public HttpOutputInterface $response;

    // For this route csrf protection turned off
    #[Params(csrf:false)]
    public function createPostAction(): ResponseInterface
    {

        //create something

        $this->response->toJson()->emit([], 201);
    }

}
```

### Turn on url parametres:

Standard route for default language route:
https://example.com/{route}/{controller}/{action}

Standard route for route with language different of default
https://example.com/{language}/{route}/{controller}/{action}

For example you want to get parametres from url:

```php
<?php

namespace App\Controller\Web;

use DI\Attribute\Inject;
use Core\Interfaces\HttpOutputInterface;
use Core\Interfaces\RouteHttpInterface;
use Core\Attributes\Params;
use Psr\Http\Message\ResponseInterface;

class ParamsController
{

    #[Inject]
    public HttpOutputInterface $response;

    // Now you can use URL parametres
    #[Params(allow:3)]
    public function indexAction(RouteHttpInterface $route): ResponseInterface
    {

        // For example our route is https://example.com/params/one/two/three
        $first = $route->getParam(0); // Value will be one
        $second = $route->getParam(1); // Value will be two
        $third = $route->getParam(2); // Value will be three
        $notExist = $route->getParam(3,'willDefault'); // willDefault

        $data = [
            'param1' => $first,
            'param2' => $second,
            'param3' => $third,
            'nonExist' => $nonExist
        ];

        $this->response->toJson()->emit($data, 201);
    }

}
```
