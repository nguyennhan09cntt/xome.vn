<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 10/11/15
 * Time: 2:09 PM
 */
class Application_Db_DbLink_News extends Application_Db_DbLink
{
    public function __construct()
    {
        $prefix = 'dbLink_News';
        if (!Zend_Registry::isRegistered($prefix)) {
            $config = Zend_Registry::get('config');
            $objDb = Zend_Db::factory(
                $config->dbLink->news->adapter,
                $config->dbLink->news->params->toArray()
            );
            Zend_Registry::set($prefix, $objDb);
        }
        $objDb = Zend_Registry::get($prefix);
        $this->setDefaultAdapter($objDb);
        $this->_db = $objDb;
    }
}