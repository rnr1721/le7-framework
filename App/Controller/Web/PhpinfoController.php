<?php

namespace App\Controller\Web;

use Core\Interfaces\Config;
use App\Controller\ControllerWeb;
use Psr\Http\Message\ResponseInterface;

class PhpinfoController extends ControllerWeb
{

    public function indexAction(Config $config): ResponseInterface
    {
        // Allow only in non-production mode
        if ($config->bool('isProduction')) {
            return $this->render('notfound.phtml', [], 404);
        }
        // Phpinfo to variable
        ob_start();
        phpinfo();
        $result = ob_get_clean();
        ob_flush();
        // Return ResponseInterface
        return $this->response->toHtml()->emit($result);
    }

}
