<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/21/15
 * Time: 1:16 AM
 */
class Application_Session_Mobile extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}