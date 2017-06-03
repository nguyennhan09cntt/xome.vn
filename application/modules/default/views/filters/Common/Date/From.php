<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 4/25/15
 * Time: 4:00 PM
 */
class View_Filter_Common_Date_From extends Application_Singleton implements Zend_Filter_Interface
{
    public function filter($value)
    {
        $value = str_replace('/', '-', $value);
        return sprintf('%s 00:00:00', date('Y-m-d', strtotime(trim($value))));
    }
}