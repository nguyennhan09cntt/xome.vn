<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 12/1/2015
 * Time: 5:20 PM
 */
class View_Helper_ShowOutOfDatePromotion extends Zend_View_Helper_Abstract
{
    public function showOutOfDatePromotion($datePromotion)
    {
        $datePromotion = strtotime($datePromotion);
        $now = time();
        $dateDiff = $now - $datePromotion;
        return $dateDiff > 0 ? 'out-of-date' : '';
    }
}