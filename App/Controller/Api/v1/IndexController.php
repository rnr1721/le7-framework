<?php

namespace App\Controller\Api\v1;

use App\Controller\ControllerApi;

class IndexController extends ControllerApi
{
    //#[Params(allow:3)]
    public function indexAction()
    {
        return $this->response->json->emit(['result' => '333'], 200);
    }

}
