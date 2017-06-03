<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 10/15/15
 * Time: 6:00 PM
 */
class Application_Db_DbLink_Air extends Application_Db_DbLink
{
    public function __construct()
    {
        $prefix = 'dbLink_Air';
        if (!Zend_Registry::isRegistered($prefix)) {
            $config = Zend_Registry::get('config');
            $objDb = Zend_Db::factory(
                $config->dbLink->air->adapter,
                $config->dbLink->air->params->toArray()
            );
            Zend_Registry::set($prefix, $objDb);
        }
        $objDb = Zend_Registry::get($prefix);
        $this->setDefaultAdapter($objDb);
        $this->_db = $objDb;
    }
}