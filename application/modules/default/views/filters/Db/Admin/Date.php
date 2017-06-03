<?php
/**
 * Created by PhpStorm.
 * User: khoaldd
 * Date: 9/17/2015
 * Time: 11:37 AM
 */
class View_Filter_Db_Admin_Date extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        return date('Y-m-d', strtotime($value));
    }
}