<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 3/24/15
 * Time: 2:11 PM
 */
class Admin_View_Helper_FormatDate extends Zend_View_Helper_Abstract
{
    public function formatDate($date)
    {
        return $date ? date('d-m-Y', strtotime($date)) : null;
    }
}