<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 9:09 PM
 */
class Admin_View_Helper_ProductOrderStatus extends Zend_View_Helper_Abstract
{
    public function productOrderStatus()
    {
        return Admin_Model_ProductOrder::getInstance()->getOrderStatus();
    }
}