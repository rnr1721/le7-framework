<?php

namespace App\Controller;

use Core\Interfaces\RequestInterface;
use Core\Interfaces\HttpOutputInterface;
use Core\Interfaces\RouteHttpInterface;
use DI\Attribute\Inject;

/**
 * Parent class for all API controllers
 * You can make own class end extend from this class
 * to make base controller or something special
 * And of course you can not extend from any base controllers
 */
class ControllerApi
{

    /**
     * Current route
     * @var RouteHttpInterface
     */
    #[Inject]
    public RouteHttpInterface $route;

    /**
     * System Request object
     * @var RequestInterface
     */
    #[Inject]
    public RequestInterface $request;

    /**
     * System Response object
     * @var HttpOutputInterface
     */
    #[Inject]
    public HttpOutputInterface $response;

}
