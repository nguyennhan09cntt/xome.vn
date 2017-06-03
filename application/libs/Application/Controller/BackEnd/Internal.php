<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/14/15
 * Time: 5:15 PM
 */
class Application_Controller_BackEnd_Internal extends Application_Controller_BackEnd
{
    public function init()
    {
        $this->adminInfo = Application_Session_Internal::getInstance()->load();
    }

}