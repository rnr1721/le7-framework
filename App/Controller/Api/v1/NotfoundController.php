<?php

namespace App\Controller\Api\v1;

use Core\Interfaces\RouteHttp;
use App\Controller\ControllerApi;
use Psr\Log\LoggerInterface;

class NotfoundController extends ControllerApi
{

    public function indexAction(LoggerInterface $logger, RouteHttp $route)
    {
        $logger->warning('404 ' . $route->getUri());
        $result = ['result' => null];
        return $this->response->json->emit($result, 404);
    }

}
