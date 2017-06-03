<?php
/**
 * Class Application_Session_Admin
 * Created by Phong Pham <xitrumhaman@yahoo.com>.
 * User: Phong Pham
 * Date: 9/30/14
 * Time: 8:46 AM
 */
class Application_Session_Admin extends Application_Session
{
    protected function __construct(){
        parent::_initSession(get_class($this));
    }

}