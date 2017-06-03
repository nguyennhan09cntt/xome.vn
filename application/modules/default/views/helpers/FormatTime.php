<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 7:03 PM
 */
class View_Helper_FormatTime extends Zend_View_Helper_Abstract
{
    public function formatTime($date=null, $pattern = 'Y-m-d')
    {
        $date = $date ? $date : date('Y-m-d');
        return date($pattern, strtotime($date));
    }
}