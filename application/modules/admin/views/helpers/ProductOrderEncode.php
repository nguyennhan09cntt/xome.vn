<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 4:49 PM
 */
class Admin_View_Helper_ProductOrderEncode extends Zend_View_Helper_Abstract
{
    public function productOrderEncode($id)
    {
        return Admin_Model_ProductOrder::getInstance()->encode($id);
    }
}