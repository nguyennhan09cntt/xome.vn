<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 3:33 PM
 */
class Application_Session_Default extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}