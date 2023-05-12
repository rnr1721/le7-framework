<?php

namespace App\Controller\Web\Admin;

use App\Controller\ControllerWeb;
use Psr\Http\Message\ResponseInterface;

class IndexController extends ControllerWeb
{
    public function indexAction() : ResponseInterface
    {
        return $this->view->render('admin/admin.twig');
    }
}
