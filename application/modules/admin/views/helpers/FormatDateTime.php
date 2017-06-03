<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 2:11 PM
 */
class Admin_View_Helper_FormatDateTime extends Zend_View_Helper_Abstract
{
    public function formatDateTime($date)
    {
        return $date ? date('d-m-Y H:i:s', strtotime($date)) : null;
    }
}