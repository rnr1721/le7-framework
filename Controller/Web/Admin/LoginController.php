<?php

namespace le7\Controller\Web\Admin;

use le7\Core\Config\ConfigInterface;
use le7\Core\User\UserManager;
use le7\Core\View\Php\PhpViewAdapter;
use le7\Controller\ControllerWebPhp;

class LoginController extends ControllerWebPhp
{

    protected ConfigInterface $config;
    protected UserManager $userManager;

    public function __construct(PhpViewAdapter $phpViewAdapter, ConfigInterface $config, UserManager $userManager)
    {
        parent::__construct($phpViewAdapter);
        $this->userManager = $userManager;
        $this->config = $config;
    }

    public function indexAction()
    {

        if (!empty($this->user)) {
            return $this->response->redirect();
        }
        
        $this->setPageTitle(_('Login'));
        
        $this->setStyle('login.css');

        $this->setContent('frontend/login.phtml');

        $this->render('layout.phtml');
    }

    public function signinAction()
    {
        // If some user logged in, redirect to mainpage
        if ($this->user) {
            return $this->response->redirect();
        }
        // Get login and password from $_POST
        $login = $this->request->wp('login');
        $password = $this->request->wp('password');
        $vcode = $this->request->wp('vcode');

        $loginForm = $this->userManager->getLoginForm($this->route);

        $loginForm->setLoginField($this->config->getUserLoginFields());

        if (!$loginForm->login($login, $password, $vcode)) {
            // Send errors if exists to flash messages
            foreach ($loginForm->getErrors() as $message) {
                $this->messagesFlash->Alert($message);
            }
            /* You dont need to call this method if run render() method.
             * But if you dont call render(), you need to call this
             * method for use flash messages
             */
            $this->handleFlashMessages();
            // Redirect to admin panel
            return $this->response->redirect('login', '', '', 'admin');
        }

        // If not logged in, redirect to mainpage
        return $this->response->redirect();
    }

    public function logoutAction()
    {
        // If some user not logged in, redirect to mainpage
        if ($this->user === null) {
            return $this->response->redirect();
        }
        $loginForm = $this->userManager->getLoginForm($this->route);
        $loginForm->logout();
        return $this->response->redirect('login', '', '', 'admin');
    }

    public function vcodeGetAjax()
    {

        $login = $this->request->wg('login');
        if ($login) {
            $loginForm = $this->userManager->getLoginForm($this->route);
            $loginForm->setLoginField($this->config->getUserLoginFields());
            $vcode = $loginForm->setVcode($login);
            if ($vcode) {
                $this->response->json->emitSuccess(200);
            }
        }
        $this->response->json->emitError(404);
    }

    private function resetAction()
    {
        if ($this->user) {
            return $this->response->redirect();
        }
        $userId = $this->request->wg('login');
        if ($userId) {
            
        }
    }

}
