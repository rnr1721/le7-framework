<?php

namespace App\Controller;

use Core\Interfaces\Request;
use Core\Interfaces\Response;
use Core\Interfaces\RouteHttp;
use DI\Attribute\Inject;

class ControllerApi
{

    /**
     * Current route
     * @var RouteHttp
     */
    #[Inject]
    public RouteHttp $route;

    /**
     * System Request object
     * @var Request
     */
    #[Inject]
    public Request $request;

    /**
     * System Response object
     * @var Response
     */
    #[Inject]
    public Response $response;

}
