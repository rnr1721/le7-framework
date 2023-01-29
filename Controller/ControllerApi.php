<?php

namespace le7\Controller;

use le7\Core\Controllers\Main\Api;

/**
 * Parent class for all API controllers
 * You can make own class end extend from this class
 * to make for example twig controller or something special
 */
class ControllerApi extends Api {

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
