<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 6/24/2015
 * Time: 11:37 AM
 */
class Application_Session_Agency extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}