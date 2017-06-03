<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 3:20 PM
 */
class Application_Session_Default_Locale extends Application_Session
{
    protected function __construct()
    {
        parent::_initSession(get_class($this));
    }
}