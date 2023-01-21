Put your controllers for API here.
for example:

<?php

namespace le7\Controller\Api\v1;

use le7\Controller\ControllerApi;

class IndexController extends ControllerApi {

    public function indexGetAction() {
        $this->response->inJSON([],200);
    }

    public function testPostAction() {
        $this->response->inJSON([],200);
    }

}

in this case it controller will be available at address:
GET: https://site.com/api/v1
POST: https://site.com/api/v1/test
