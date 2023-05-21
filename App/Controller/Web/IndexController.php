<?php

namespace App\Controller\Web;

use Core\Interfaces\MessageCollectionFlashInterface;
use Core\Entify\Interfaces\EntificationInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controller\ControllerWeb;

class IndexController extends ControllerWeb
{

    public function indexAction(\Core\Interfaces\UrlInterface $url): ResponseInterface
    {

        // Setup assets to webbpage
        $this->webPage->setScriptFromLib('bootstrap5', false)
                ->setStyleFromLib('fontawesome6,bootstrap5');
        // Set page title
        $this->webPage->setPageTitle('Page title');
        //Set content template
        $this->setContentTemplate('mainpage.twig');
        // Render the layout
        return $this->view->render('layout.twig', []);
    }

    // Action with processing form (POST)
    public function indexPostAction(
            EntificationInterface $entify,
            MessageCollectionFlashInterface $messages
    )
    {

        // Get form provider with rules
        // Rules stored in App\Entity\Testform
        $form = $entify->getFormProvider($this->request->getRequest(), 'testform');

        // Gey entity
        $cleanData = $form->getEntity();

        // Export entity to array
        $data = $cleanData->export();

        // Check form errors
        if ($cleanData->getErrors()) {
            foreach ($cleanData->getErrors() as $error) {
                // Add flash messages
                $messages->alert($error);
            }
            // Redirect if errors
            return $this->response->redirect();
        }

        // Do something with data if no errors
        print_r($data);

        exit;
    }

}
