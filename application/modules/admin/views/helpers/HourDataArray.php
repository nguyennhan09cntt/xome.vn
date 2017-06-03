<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/12/15
 * Time: 10:55 PM
 */
class Admin_View_Helper_HourDataArray extends Zend_View_Helper_Abstract
{
    public function hourDataArray()
    {
        $result = array();
        for ($i=0; $i<24; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }
}