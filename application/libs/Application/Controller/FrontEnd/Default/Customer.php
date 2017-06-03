<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/22/15
 * Time: 2:07 PM
 */
class Application_Controller_FrontEnd_Default_Customer extends Application_Controller_FrontEnd_Default
{
    public function init()
    {
        parent::init();
        if (!$this->customerInfo) {
            $this->gotoUrl('/');
        }
    }
}