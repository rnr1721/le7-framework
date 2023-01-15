Place for API controllers: one API version - one folder - v1,v2 etc.
After adding folder You need to add route for it in ./config/routes.php

    'apiv1' => [
        'key' => 'apiv2',
        'type' => 'api',
        'address' => 'api/v2',
        'namespace' => 'le7\Api\v2',
        'paramsCount' => 7,
        'namespaceSystem' => ''
    ]

After it, you can place controller to ./Api/v2:

<?php

namespace le7\Api\v2;

use le7\controllers\ControllerApi;

class IndexController extends ControllerApi {

    public function indexGetAction($params) {https://site.ru/api/v2
        $result = array(
            'response' => 'Test call of GET method of API ',
            'params' => $params
        );
        $this->response->inJSON($result, 200);
    }
    
}

or another example:

<?php

namespace le7\Api\v2;

use le7\controllers\ControllerApi;

class TestController extends ControllerApi {

    public function indexGetAction($params) {https://site.ru/api/v2/test
        $result = array(
            'response' => 'Test call of GET method of API ',
            'params' => $params
        );
        $this->response->inJSON($result, 200);
    }
    
}
