<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/7/15
 * Time: 10:15 AM
 */
class Application_Session_Operation extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}