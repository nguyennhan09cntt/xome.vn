<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/12/15
 * Time: 10:57 PM
 */
class Admin_View_Helper_MinuteDataArray extends Zend_View_Helper_Abstract
{
    public function minuteDataArray()
    {
        $result = array();
        for ($i=0; $i<60; $i=$i+5) {
            $result[$i] = $i;
        }
        return $result;
    }
}