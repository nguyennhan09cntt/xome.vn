<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/2/15
 * Time: 10:39 AM
 */
class Application_Controller_FrontEnd_Mobile_Customer extends Application_Controller_FrontEnd_Mobile
{
    public function init()
    {
        parent::init();
        if (!$this->customerInfo) {
            $this->gotoUrl('/');
        }
    }
}