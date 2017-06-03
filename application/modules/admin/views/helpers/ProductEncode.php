<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 10:05 AM
 */

class Admin_View_Helper_ProductEncode extends Zend_View_Helper_Abstract
{
    public function productEncode($id)
    {
        return Admin_Model_Product::getInstance()->encode($id);
    }
}