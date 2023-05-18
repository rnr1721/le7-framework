<?php

declare(strict_types=1);

namespace App\Model;

use Core\Database\Redbean\Model;
use Core\Entify\Interfaces\ModelInterface;

/**
 * Test rules. Feel free to delete it if not need
 */
class Testform extends Model implements ModelInterface
{

    public function getRules(): array
    {
        return [
            'id' => [
                'label' => 'ID',
                'validate' => '',
                'default' => 0
            ],
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
