<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 6/24/2015
 * Time: 3:12 PM
 */
class Application_Controller_BackEnd_Agency extends Application_Controller_Agency
{
    public function init()
    {
        $this->agencyInfo = Application_Session_Agency::getInstance()->load();
    }
}