<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 9/14/15
 * Time: 5:16 PM
 */
class Application_Session_Bus extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}