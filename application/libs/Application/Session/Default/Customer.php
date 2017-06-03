<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/4/15
 * Time: 9:13 AM
 */
class Application_Session_Default_Customer extends Application_Session
{
    protected function __construct()
    {
        parent::_initSession(get_class($this));
    }
}