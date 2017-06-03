<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/11/15
 * Time: 2:22 PM
 */
class View_Filter_Common_Date extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
{
    return date('Y-m-d', strtotime(trim($value)));
}
}