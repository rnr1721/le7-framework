<?php

namespace le7\Controller;

use le7\Core\View\Php\PhpViewAdapter;
use le7\Core\Controllers\Main\Web;

/**
 * Parent class for all controllers with PHP template engine
 */
class ControllerWebPhp extends Web {

     public function __construct(PhpViewAdapter $phpView)
     {
         parent::__construct();
         $this->view = $phpView->getView();
     }

     /**
     * This method will run after controller constructor
     * You can return mixed data from this method and use
     * it as parameter in any action method
     * You can add this method to any controller, and then
     * it will be override this method
     * @return mixed
     */
    public function trigger() {
        return array();
    }

}
