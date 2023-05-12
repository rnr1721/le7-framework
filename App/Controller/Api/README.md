# Api controllers and methods folder
Place for API controllers: one API version - one folder - v1,v2 etc.
After adding folder You need to add route for it in ./config/routes.php

```php
        'apiv2' => [
            'key' => 'apiv1',
            'type' => 'api',
            'address' => '/api/v2',
            'namespace' => 'App\Controller\Api\v2',
            'params' => 7,
            'multilang' => false
        ],
```

After it, you can place controller to .App/Controller/Api/v2:

<?php

namespace App\Controller\Api\v2;

use App\Controller\ControllerApi;

class IndexController extends ControllerApi {

    public function indexGetAction() {https://site.ru/api/v2
        $result = array(
            'response' => 'Test call of GET method of API '
        );
        $this->response->inJSON($result, 200);
    }
    
}

or another example:

<?php

namespace App\Controller\Api\v2;

use App\Controller\ControllerApi;

class TestController extends ControllerApi {

    public function indexGetAction($params) {https://site.ru/api/v2/test
        $result = array(
            'response' => 'Test call of GET method of API ',
            'params' => $this->request->getParams()
        );
        $this->response->inJSON($result, 200);
    }
    
}
