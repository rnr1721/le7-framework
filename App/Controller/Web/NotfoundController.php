<?php

namespace App\Controller\Web;

use Core\Interfaces\View;
use Psr\Http\Message\ResponseInterface;

class NotfoundController
{

    public function indexAction(View $view): ResponseInterface
    {
        return $view->render('notfound.twig', [], 404);
    }

}
