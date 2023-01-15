Put your controllers for CLI here.
for example:

<?php

namespace le7\Cli;

use le7\controllers\ControllerCli;

class TestController extends ControllerCli {

    public function indexAction($params) {
        $this->stdout('Hello World!');
        print_r($params);
    }

}

in this case it controller will be available at command:
./cli --c test:index --p1 hello2 --p2 world2
