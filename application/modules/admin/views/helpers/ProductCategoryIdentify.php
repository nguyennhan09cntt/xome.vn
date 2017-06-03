<?php
/**
 * Created by PhpStorm.
 * User: Nhan
 * Date: 4/23/2016
 * Time: 11:38 AM
 */

class Admin_View_Helper_ProductCategoryIdentify extends Zend_View_Helper_Abstract
{
    public function productCategoryIdentify($id)
    {
        $data = Model_ProductCategory::getInstance()->getAll();
        return isset($data[$id]) ? $data[$id][DbTable_Product_Category::COL_PRODUCT_CATEGORY_IDENTIFY] : null;
    }
}