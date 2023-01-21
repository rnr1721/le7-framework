Put your controllers for Web here.
for example:

<?php

namespace le7\Controller\Web;

use le7\Controller\ControllerWebSmarty;

class IndexController extends ControllerWebSmarty {

    public function indexAction() {
        echo 'mainpage';
    }

}

in this case it controller will be available at address:
GET: https://site.com

on mainpage (IndexController) you can have only one action - indexAction;

Another example:
<?php

namespace le7\Controller\Web;

use le7\Controller\ControllerWebSmarty;

class IndexController extends ControllerWebSmarty {

    public function indexAction() {
        $this->assign('myVar',"Hello world!");
        $this->render('template.tpl');
    }

}

In this example you must have Smarty template in ./htdocs/themes/{Theme}/templates/template.tpl

Another example:

<?php

namespace le7\Controller\Web;

use le7\Controller\ControllerWeb;

class TestController extends ControllerWeb {

    // url: https://site.com/{LANG}/test
    public function indexAction() {
        echo test page';
    }

    // url: https://site.com/{LANG}/test/{param1}
    // Get the param from url (if not present action with this name)
    #[Param(wlp:1)]
    public function test2Action($params) {
        print_r($params);
    }

    // url: https://site.com/{LANG}/test/test
    public function testAction() {
        echo 'test action';
    }

    // url: https://site.com/{LANG}/test/test2/{param1}
    // Get the param from url
    #[Param(wlp:1)]
    public function test2Action($params) {
        print_r($params);
    }

    // url: https://site.com/{LANG}/test/test3
    // This will return 404 if GET param "myName" is not set
    // if this GET parameter is set, it print them
    public function test3Action() {
        // Get the GET parameter ?myName=John
        $name = $this->request->wg('myName',false);
        if ($name === false) {
            return 404;
        }
        echo $name;
    }

}
