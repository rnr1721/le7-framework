<?php

namespace le7\Model;

use le7\Core\User\UserInterface;
use le7\Custom\Model;

class User extends Model implements UserInterface {

    public static function getRules(): array {
        return array(
            'id' => [
                'label' => 'ID',
                'validate' => ''
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
                'default' => 'client',
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

    public function can(string $role): bool {
        $roles = $this->getRoles($role);
        if (in_array($role, $roles)) {
            return true;
        }
        return false;
    }

    public function getRoles(): array {
        if (!empty($this->bean->roles)) {
            return explode(',', $this->bean->roles);
        }
        return array();
    }

    protected function filter_roles(string|array $roles): string {
        if (is_array($roles)) {
            return implode(',', $roles);
        }
        return $roles;
    }

    public function getIsActive(): bool {
        if ($this->bean->active === '1') {
            return true;
        }
        return false;
    }

    public function getUsername(): string {
        return $this->bean->username;
    }

}
