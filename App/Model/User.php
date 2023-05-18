<?php

declare(strict_types=1);

namespace App\Model;

use Core\Database\Redbean\Model;
use Core\Entify\Interfaces\ModelInterface;

/**
 * User model
 */
class User extends Model implements ModelInterface
{

    public function getRules(): array
    {
        return array(
            'id' => [
                'label' => 'ID',
                'validate' => '',
                'default' => 0
            ],
            'username' => [
                'label' => _('Login'),
                'validate' => 'minlength:3|maxlength:15',
                'unique' => true,
                'check' => false
            ],
            'email' => [
                'label' => _('User email'),
                'validate' => 'required|email',
                'unique' => false,
                'check' => false
            ],
            'password' => [
                'label' => _('User password'),
                'validate' => 'required',
                'unique' => false,
                'check' => false,
                'filter' => false
            ],
            'active' => [
                'label' => _('Active'),
                'validate' => 'required',
                'unique' => false,
                'check' => false,
                'default' => '1'
            ],
            'roles' => [
                'label' => _('Roles'),
                'validate' => 'required',
                'unique' => false,
                'check' => false,
                'default' => 'user',
                'filter' => true
            ],
            'vcode' => [
                'label' => _('Verification code'),
                'validate' => 'required',
                'unique' => false,
                'check' => false,
                'default' => '0',
                'filter' => false
            ],
        );
    }

}
