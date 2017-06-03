<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/25/15
 * Time: 4:01 PM
 */
class View_Filter_Common_Date_To extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = str_replace('/', '-', $value);
        return sprintf('%s 23:59:59', date('Y-m-d', strtotime(trim($value))));
    }
}