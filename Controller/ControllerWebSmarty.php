<?php

namespace le7\Controller;

use le7\Core\View\Smarty\SmartyAdapter;
use le7\Core\Controllers\Main\Web;

/**
 * Parent class for all controllers with Smarty template engine
 */
class ControllerWebSmarty extends Web {

     public function __construct(SmartyAdapter $smartyView)
     {
         parent::__construct();
         $this->view = $smartyView;
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
