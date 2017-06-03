<?php

/**
 * Created by PhpStorm.
 * User: nhannvt
 * Date: 11/10/2015
 * Time: 4:47 PM
 */
class Controller_Helper_ShowRateLabel extends Zend_Controller_Action_Helper_Abstract
{
    public function direct($rateValue)
    {
        $rateValueListing = Model_CompanyRating::getInstance()->rateValueListing();
        $label = isset($rateValueListing[$rateValue]) ? $rateValueListing[$rateValue] : null;
        if ($label) {
            $label = sprintf(
                "Đánh giá( %s )",
                $label
            );
        } else {
            $label = '(Sắp có đánh giá)';
        }
        return $label;
    }
}