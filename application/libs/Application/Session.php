<?php
/**
 * class Application_Session
 * Created by Phong Pham <xitrumhaman@yahoo.com>.
 * User: Phong Pham
 * Date: 9/30/14
 * Time: 8:46 AM
 */
class Application_Session extends Application_Singleton
{
    protected function __construct()
    {
    }

    /**
     * @param string $nameSpace
     */
    protected function _initSession($nameSpace)
    {
        Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_Session($nameSpace));
    }

    /**
     * Wrapper write method of Zend_Auth
     * @param object $info
     */
    public function save($info)
    {
        Zend_Auth::getInstance()->getStorage()->write($info);
    }

    /**
     * Reset session
     */
    public function reset()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }

    /**
     * Load authenticate
     * @return mixed
     */
    public function load()
    {
        return Zend_Auth::getInstance()->getStorage()->read();
    }
}