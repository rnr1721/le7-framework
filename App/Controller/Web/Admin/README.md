# Admin namespace

This is default namespace for adresses https://example.com/admin,
https://example.com/ru/admin etc. Feel free to change it in routing settings
in ./config/routes.php

```php
        'admin' => [
            'key' => 'admin', // Unique key
            'type' => 'web', // Type - web or api
            'address' => '/admin', // Address, example: https://example.com/admin
            'namespace' => 'App\Controller\Web\Admin', // Namespace controllers
            'params' => 7, //Params (segments) in url after slash
            'multilang' => true
        ],
```
In this case we can create web controllers in this dir.
All controllers in this dir must have App\Controller\Web\Admin namespace
Of course you can make own namespace, create own route and place here your
controllers.
All controllers must return PSR ResponseInterface

## Example of the controller in this dir:

```php
<?php

namespace App\Controller\Web\Admin;

use Core\Interfaces\RouteHttpInterface;
use App\Controller\ControllerWeb;

class IndexController extends ControllerWeb
{

    // You can inject any classes from container
    // to constructor or in action methods
    #[Params(allow:3)] // Three URL params after URL
    public function indexAction(RouteHttpInterface $route)
    {
        
        $param1 = $route->getParam(0) ?? 'default value 1';
        $param2 = $route->getParam(1) ?? 'default value 2';
        $param3 = $route->getParam(2) ?? 'default value 3';
        
        $this->assign('param1',$param1);
        $this->assign('param2',$param2);
        $this->assign('param3',$param3);
        
        return $this->view->render('admin/admin.phtml');
    }

}
```

```php
<?php

namespace App\Controller\Web\Admin;

use Core\Interfaces\RouteHttpInterface;
use App\Controller\ControllerWeb;

class IndexController extends ControllerWeb
{

    // You can inject any classes from container
    // to constructor or in action methods
    #[Params(allow:1)] // One URL params after URL
    public function indexAction(RouteHttpInterface $route)
    {
        
        // Get param from URL
        $param1 = $route->getParam(0) ?? 'No name';
        
        // Assign data to template
        $data = [
            'param1' => $param1
        ];
        
        // Response with code 201
        return $this->view->render('admin/admin.phtml', $data, 201);
    }

}
```

```php
<?php

namespace App\Controller\Web\Admin;

use Core\Interfaces\RouteHttpInterface;
use App\Controller\ControllerWeb;

class IndexController extends ControllerWeb
{

    // You can inject any classes from container
    // to constructor or in action methods
    #[Params(allow:1)] // One URL params after URL
    public function indexAction(RouteHttpInterface $route)
    {
        
        // Get param from URL
        $param1 = $route->getParam(0) ?? 'No name';
        
        if ($param1 !== 'joe') {
            return $this->view->render('notfound.phtml');
        }
        
        // Response with code 201
        // Same as $this->view->render...
        return $this->render('layout.phtml', [], 200);
    }

}
```

```php
<?php

namespace App\Controller\Web\Admin;

use App\Controller\ControllerWeb;

class IndexController extends ControllerWeb
{
    // GET https://example.com/admin
    // GET https://example.com/ru/admin
    // GET https://example.com/es/admin
    public function indexAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

    // PUT https://example.com/admin
    // PUT https://example.com/ru/admin
    // PUT https://example.com/es/admin
    public function indexPutAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

}
```

```php
<?php

namespace App\Controller\Web\Admin;

use App\Controller\ControllerWeb;

class TestController extends ControllerWeb
{

    // GET https://example.com/admin/test
    // GET https://example.com/ru/admin/test
    // GET https://example.com/es/admin/test
    public function indexAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

    // POST https://example.com/admin/test
    // POST https://example.com/ru/admin/test
    // POST https://example.com/es/admin/test
    public function indexPostAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

    public function indexPutAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

    // POST https://example.com/admin/test/test
    // POST https://example.com/ru/admin/test/test
    // POST https://example.com/es/admin/test/test
    public function testPostAction()
    {
        // code
    }

    // GET https://example.com/admin/test/test
    // GET https://example.com/ru/admin/test/test
    public function testAction()
    {
        return $this->view->render('admin/admin.phtml');
    }

    // Ajax GET https://example.com/admin/test/test
    // Ajax GET https://example.com/ru/admin/test/test
    public function testAjax()
    {
        return $this->response->toJson()->emitSuccess(['result' => true], 200);
    }

    // Ajax POST https://example.com/admin/test/test
    // Ajax POST https://example.com/ru/admin/test/test
    public function testPostAjax()
    {
        return $this->response->toJson()->emitSuccess(['result' => true], 200);
    }

}
```
