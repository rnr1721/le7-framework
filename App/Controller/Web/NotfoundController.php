<?php

namespace App\Controller\Web;

use Core\Interfaces\WebPage;
use Core\Interfaces\View;
use Psr\Http\Message\ResponseInterface;

class NotfoundController
{

    public function indexAction(View $view, WebPage $webPage): ResponseInterface
    {
        $webPage->setStyleFromLib('bootstrap5', true);
        return $view->render('notfound.twig', [], 404);
    }

}
