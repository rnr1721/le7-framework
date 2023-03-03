<?php

namespace le7\Controller\Api\v1;

use le7\Core\View\HtmlTemplate;
use le7\Core\User\Notifications\Notifications;
use le7\Controller\ControllerApi;

class ContactsController extends ControllerApi {

    private HtmlTemplate $htmlTemplate;
    private Notifications $notifications;

    public function __construct(HtmlTemplate $htmlTemplate, Notifications $notifications) {
        parent::__construct();
        $this->htmlTemplate = $htmlTemplate;
        $this->notifications = $notifications;
    }

    public function loginPostAction() {
        if ($this->user) {
            $this->messages->Alert(_('While this request you dont need X-Auth-Token'));
            $this->response->json->emitError(400);
        }
        $login = $this->request->wp('login');
        $password = $this->request->wp('password');
        $loginForm = $this->userIdentityFactory->getLoginForm($this->route, $this->htmlTemplate, $this->notifications);
        $loginForm->setLoginField($this->config->getUserLoginFields());
        $token = $loginForm->login($this->db, $login, $password);
        if (!$token) {
            foreach ($loginForm->getErrors() as $message) {
                $this->messages->Error($message);
            }
            $this->response->json->emitError(404);
        }
        $tokens = $this->userIdentityFactory->getTokens();
        $userId = $tokens->getUserId($token);
        $user = $this->db->findOne('user', ' id = ? ', [$userId])->export();
        unset($user['password']);
        $result['user_info'] = $user;
        $result['user_token'] = $token;
        $this->response->json->emitSuccess(201, $result);
    }

    public function logoutDeleteAction() {
        $loginForm = $this->userIdentityFactory->getLoginForm($this->route, $this->htmlTemplate, $this->notifications);
        if ($loginForm->logout()) {
            $res['status'] = 1;
            $this->response->json->emitSuccess(200, $res);
        } else {
            $res['status'] = 0;
            $this->response->json->emitError(404, $res);
        }
    }

}
