<?php
/**
 * Created by PhpStorm.
 * User: khoaldd
 * Date: 9/17/2015
 * Time: 11:39 AM
 */
class View_Filter_Db_Admin_Phone extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = str_replace(' ', '', $value);
        return strip_tags(trim($value));
    }
}