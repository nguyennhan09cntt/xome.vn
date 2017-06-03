<?php

/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 3/21/2016
 * Time: 10:11 PM
 */
class View_Helper_ProductEncode extends Zend_View_Helper_Abstract
{
    public function productEncode($id)
    {
        return Model_Product::getInstance()->encode($id);
    }
}