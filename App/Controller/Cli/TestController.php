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
        $this->stdout('Option1 is ' . $this->opt_option1);
        $this->stdout('Option2 is ' . $this->opt_option2);
    }

    public function inputAction()
    {
        $a = $this->stdin(false, 'Please input "Y":');
        while ($a !== 'Y') {
            $this->stdout('Please input correct data');
            $a = $this->stdin(false, 'Please input "Y":');
        }
        $this->stdout('Your input: ' . $a);
    }

}
