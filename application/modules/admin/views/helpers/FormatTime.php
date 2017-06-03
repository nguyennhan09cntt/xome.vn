<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 2:11 PM
 */
class Admin_View_Helper_FormatTime extends Zend_View_Helper_Abstract
{
    public function formatTime($time)
    {
        return date('H:i', strtotime($time));
    }
}