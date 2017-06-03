<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/6/15
 * Time: 3:01 PM
 */
class Application_Session_FrontEnd extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}