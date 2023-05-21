<?php

namespace App\Controller\Web;

use Core\Interfaces\WebPageInterface;
use Core\Interfaces\ViewInterface;
use Psr\Http\Message\ResponseInterface;

class NotfoundController
{

    public function indexAction(ViewInterface $view, WebPageInterface $webPage): ResponseInterface
    {
        $webPage->setStyleFromLib('bootstrap5', true);
        return $view->render('notfound.twig', [], 404);
    }

}
