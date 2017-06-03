<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 6/4/2015
 * Time: 8:53 AM
 */
class View_Filter_Db_Config_Shorten_Url_ShortUrl extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return strtolower(strip_tags(trim($value)));
    }
}