<?php

namespace le7\Controller;

use le7\Core\Controllers\Main\WebPhp;

/**
 * Parent class for all controllers with PHP template engine
 */
class ControllerWebPhp extends WebPhp {

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
