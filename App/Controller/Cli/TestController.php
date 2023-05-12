<?php

namespace App\Controller\Cli;

use App\Controller\ControllerCli;

class TestController extends ControllerCli
{

    /**
     * Test option description
     * @var string
     */
    public string $opt_option1 = 'value of option 1';
    
    /**
     * Test option 2 description - is required param
     * @var string
     */
    public string $opt_option2;

    public function indexAction()
    {
        $this->stdout('Test dummy controller');
    }

    public function anotherAction()
    {
        $this->stdout('Option1 is '.$this->opt_option1);
    }
    
}
