<?php

declare(strict_types=1);

namespace App\Entity;

use Core\Entify\Interfaces\RulesModelInterface;

/**
 * Test rules. Feel free to delete it if not need
 */
class Testform implements RulesModelInterface
{

    public function getRules(): array
    {
        return [
            'username' => [
                'label' => 'Username',
                'validate' => 'required|minlength:3|maxlength:40'
            ],
            'password' => [
                'label' => 'Password',
                'validate' => 'required|minlength:5|maxlength:40'
            ],
            'mynumber' => [
                'label' => 'Number',
                'validate' => 'min:20|max:40|numeric'
            ]
        ];
    }

}
